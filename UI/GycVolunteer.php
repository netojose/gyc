<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Sends the volunteer registration form of the Volunteer block (blocks/volunteer)
 * by email to the block's recipient, or to the site admin when that is empty.
 *
 * Works like GycContact: the form posts to admin-post.php and the visitor is sent
 * back to the same page with ?volunteer=<status>, which the block reads to show
 * a confirmation or an error. The recipient is signed, so the form can't be
 * changed to send mail to any other address.
 */
class GycVolunteer
{
    const ACTION = 'gyc_volunteer';
    const NONCE_FIELD = '_gyc_volunteer_nonce';
    const STATUSES = array('sent', 'invalid', 'failed', 'expired', 'wait');
    const MIN_AGE = 12;
    const MAX_AGE = 99;

    public function __construct()
    {
        add_action('admin_post_nopriv_' . self::ACTION, array($this, 'handle'));
        add_action('admin_post_' . self::ACTION, array($this, 'handle'));
    }

    public static function signature($recipient)
    {
        return wp_hash(self::ACTION . '|' . $recipient);
    }

    /**
     * Where applications go: the address set in the block, or the site admin's.
     */
    public static function recipient($attributes)
    {
        $recipient = empty($attributes['recipient']) ? '' : sanitize_email($attributes['recipient']);
        return $recipient ? $recipient : sanitize_email(get_option('admin_email'));
    }

    /**
     * The result of the last submission, read from the URL after the redirect.
     */
    public static function status()
    {
        $status = isset($_GET['volunteer']) ? sanitize_key(wp_unslash($_GET['volunteer'])) : '';
        return in_array($status, self::STATUSES, true) ? $status : null;
    }

    public function handle()
    {
        if (empty($_POST[self::NONCE_FIELD]) || ! wp_verify_nonce(sanitize_key(wp_unslash($_POST[self::NONCE_FIELD])), self::ACTION)) {
            $this->finish('expired');
        }

        // Hidden field that only bots fill in: pretend it worked so they don't retry
        if (! empty($_POST['website'])) {
            $this->finish('sent');
        }

        $recipient = sanitize_email(wp_unslash($_POST['to'] ?? ''));
        $signature = sanitize_text_field(wp_unslash($_POST['to_signature'] ?? ''));
        if (! $recipient || ! hash_equals(self::signature($recipient), $signature)) {
            $this->finish('failed');
        }

        $full_name = sanitize_text_field(wp_unslash($_POST['full_name'] ?? ''));
        $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
        $country = sanitize_text_field(wp_unslash($_POST['country'] ?? ''));
        $age = sanitize_text_field(wp_unslash($_POST['age'] ?? ''));
        $church = sanitize_text_field(wp_unslash($_POST['church'] ?? ''));
        $details = sanitize_textarea_field(wp_unslash($_POST['details'] ?? ''));
        $consent = ! empty($_POST['consent']);

        $skills = isset($_POST['skills']) && is_array($_POST['skills']) ? wp_unslash($_POST['skills']) : array();
        $skills = array_slice(array_values(array_filter(array_map('sanitize_text_field', $skills), function ($skill) {
            return $skill !== '' && mb_strlen($skill) <= 100;
        })), 0, 30);

        $is_valid = $full_name !== ''
            && is_email($email)
            && $country !== ''
            && ctype_digit($age) && (int) $age >= self::MIN_AGE && (int) $age <= self::MAX_AGE
            && $church !== ''
            && count($skills) > 0
            && $consent
            && mb_strlen($full_name) <= 200
            && mb_strlen($country) <= 100
            && mb_strlen($church) <= 200
            && mb_strlen($details) <= 5000;
        if (! $is_valid) {
            $this->finish('invalid');
        }

        // One application per minute from the same address
        $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
        $limit_key = 'gyc_volunteer_' . md5($ip);
        if (get_transient($limit_key)) {
            $this->finish('wait');
        }

        $subject = sprintf('[%s] Volunteer registration: %s', wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES), $full_name);
        $body = implode("\n", array(
            'Full name: ' . $full_name,
            'Email: ' . $email,
            'Country: ' . $country,
            'Age: ' . (int) $age,
            'Church membership: ' . $church,
            'Skills: ' . implode(', ', $skills),
            'Sent from: ' . $this->back_url(),
            '',
            'About their skills and experience:',
            $details !== '' ? $details : '-',
        ));
        $headers = array(sprintf('Reply-To: "%s" <%s>', str_replace('"', '', $full_name), $email));

        $sent = wp_mail($recipient, $subject, $body, $headers);
        if ($sent) {
            set_transient($limit_key, 1, MINUTE_IN_SECONDS);
        }

        $this->finish($sent ? 'sent' : 'failed');
    }

    private function back_url()
    {
        $referer = wp_get_referer();
        return remove_query_arg('volunteer', $referer ? $referer : home_url('/'));
    }

    private function finish($status)
    {
        wp_safe_redirect(add_query_arg('volunteer', $status, $this->back_url()) . '#volunteer-form', 303);
        exit;
    }
}
