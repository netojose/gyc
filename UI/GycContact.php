<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Sends the message form of the Contact block (blocks/contact) by email.
 *
 * The form posts to admin-post.php and the visitor is sent back to the same page
 * with ?contact=<status>, which the block reads to show a confirmation or an error.
 * The recipient comes from the block settings and is signed, so the form can't be
 * changed to send mail to any other address.
 */
class GycContact
{
    const ACTION = 'gyc_contact';
    const NONCE_FIELD = '_gyc_contact_nonce';
    const STATUSES = array('sent', 'invalid', 'failed', 'expired', 'wait');

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
     * The result of the last submission, read from the URL after the redirect.
     */
    public static function status()
    {
        $status = isset($_GET['contact']) ? sanitize_key(wp_unslash($_GET['contact'])) : '';
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

        $first_name = sanitize_text_field(wp_unslash($_POST['first_name'] ?? ''));
        $last_name = sanitize_text_field(wp_unslash($_POST['last_name'] ?? ''));
        $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
        $topic = sanitize_text_field(wp_unslash($_POST['topic'] ?? ''));
        $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));

        $is_valid = $first_name !== ''
            && is_email($email)
            && $message !== ''
            && mb_strlen($first_name) <= 100
            && mb_strlen($last_name) <= 100
            && mb_strlen($topic) <= 100
            && mb_strlen($message) <= 5000;
        if (! $is_valid) {
            $this->finish('invalid');
        }

        // One message per minute from the same address
        $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
        $limit_key = 'gyc_contact_' . md5($ip);
        if (get_transient($limit_key)) {
            $this->finish('wait');
        }

        $name = trim($first_name . ' ' . $last_name);
        $subject = sprintf('[%s] %s: %s', wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES), $topic !== '' ? $topic : 'Message', $name);
        $body = implode("\n", array(
            'Name: ' . $name,
            'Email: ' . $email,
            'Topic: ' . ($topic !== '' ? $topic : '-'),
            'Sent from: ' . $this->back_url(),
            '',
            $message,
        ));
        $headers = array(sprintf('Reply-To: "%s" <%s>', str_replace('"', '', $name), $email));

        $sent = wp_mail($recipient, $subject, $body, $headers);
        if ($sent) {
            set_transient($limit_key, 1, MINUTE_IN_SECONDS);
        }

        $this->finish($sent ? 'sent' : 'failed');
    }

    private function back_url()
    {
        $referer = wp_get_referer();
        return remove_query_arg('contact', $referer ? $referer : home_url('/'));
    }

    private function finish($status)
    {
        wp_safe_redirect(add_query_arg('contact', $status, $this->back_url()) . '#contact-form', 303);
        exit;
    }
}
