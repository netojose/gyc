<?php

if (! defined('ABSPATH')) {
    exit;
}

class GycUI
{
    // Page setting (Page sidebar → Header and footer) that switches the site header and footer to dark
    const DARK_CHROME_META = 'gyc_dark_header_footer';
    const DARK_CHROME_POST_TYPES = array('page', 'event');

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'setup_assets'));
        add_action('init', array($this, 'register_meta'));
        add_filter('should_load_separate_core_block_assets', '__return_false', 11);
    }

    public function register_meta()
    {
        foreach (self::DARK_CHROME_POST_TYPES as $post_type) {
            register_post_meta($post_type, self::DARK_CHROME_META, array(
                'type' => 'boolean',
                'single' => true,
                // Events have a dark design, so they start dark; pages start light
                'default' => $post_type === 'event',
                'show_in_rest' => true,
                'auth_callback' => function ($allowed, $meta_key, $post_id) {
                    return current_user_can('edit_post', $post_id);
                },
            ));
        }
    }

    /**
     * Whether the page being viewed asks for the dark header and footer.
     */
    public static function is_dark_chrome()
    {
        if (!is_singular(self::DARK_CHROME_POST_TYPES)) {
            return false;
        }

        return (bool) get_post_meta(get_queried_object_id(), self::DARK_CHROME_META, true);
    }

    public function setup_assets()
    {
        wp_dequeue_style('global-styles');
        wp_deregister_style('global-styles');

        wp_enqueue_style(
            'gyc-theme',
            get_template_directory_uri() . '/build-site/styles.css',
            array(),
            filemtime(get_template_directory() . '/build-site/styles.css')
        );

        wp_enqueue_script(
            'gyc-scripts',
            get_template_directory_uri() . '/build-site/app.js',
            array(),
            filemtime(get_template_directory() . '/build-site/app.js'),
            true
        );
    }

    /**
     * Turns a link entered in a block into a usable URL:
     * "/about" becomes a URL on this site and, when $front_page_anchors is true,
     * "#section" points to the front page when used elsewhere.
     */
    public static function resolve_url($url, $front_page_anchors = true)
    {
        $url = trim((string) $url);

        if ($url === '') {
            return '';
        }

        if (strpos($url, '#') === 0) {
            return ($url === '#' || !$front_page_anchors || is_front_page()) ? $url : home_url('/' . $url);
        }

        if (strpos($url, '/') === 0 && strpos($url, '//') !== 0) {
            return home_url($url);
        }

        if (is_email($url)) {
            return 'mailto:' . $url;
        }

        return $url;
    }

    /**
     * Timestamp of a "Registration opens on" date and time ("2027-03-01T10:00"), read in
     * Central European Time (CET, or CEST in summer). Null when empty, invalid or already passed,
     * so the button is simply shown as active.
     */
    public static function opens_at($value)
    {
        $value = substr(trim((string) $value), 0, 16);

        if ($value === '') {
            return null;
        }

        $date = DateTimeImmutable::createFromFormat('!Y-m-d\TH:i', $value, new DateTimeZone('Europe/Berlin'));

        return ($date && $date->getTimestamp() > time()) ? $date->getTimestamp() : null;
    }

    /**
     * "Opens 1 March 2027, 10:00 CET" for a timestamp from opens_at().
     */
    public static function opens_note($timestamp)
    {
        /* translators: %s: date and time registration opens, e.g. "1 March 2027, 10:00 CET" */
        return sprintf(__('Opens %s', 'gyc'), wp_date('j F Y, H:i T', $timestamp, new DateTimeZone('Europe/Berlin')));
    }

    /**
     * A button that stays disabled until registration opens. Prints the disabled version
     * with the opening time, plus the real link hidden; assets/js/registration-opens.js
     * swaps them when the time comes, so cached pages and open tabs switch too.
     *
     * $link_html is the full, already escaped <a> element of the active button. Tailwind doesn't
     * scan this folder, so $classes and $note_classes must be written out in the block's render.php.
     * Pass null as $note_classes to print the "Opens …" note elsewhere: give that element
     * data-gyc-closed="<timestamp>" so it is removed at the same moment.
     */
    public static function closed_button($timestamp, $link_html, $label, $classes, $note_classes, $wrapper_classes = '')
    {
        $note = self::opens_note($timestamp);
        $link_html = preg_replace('/^<a\s/', '<a hidden data-gyc-opens="' . esc_attr((string) $timestamp) . '" ', trim($link_html), 1);

        return $link_html
            . '<span data-gyc-closed="' . esc_attr((string) $timestamp) . '" class="' . esc_attr(trim('inline-flex flex-col items-start gap-1.5 ' . $wrapper_classes)) . '">'
            . '<span aria-disabled="true" class="' . esc_attr($classes) . '">' . esc_html($label) . '</span>'
            . ($note_classes === null ? '' : '<span class="' . esc_attr($note_classes) . '">' . esc_html($note) . '</span>')
            . '</span>';
    }

    /**
     * Whether a link entered in a block points to the page being viewed.
     */
    public static function is_current_url($url)
    {
        $url = self::resolve_url($url);

        if ($url === '' || strpos($url, '#') !== false) {
            return false;
        }

        $request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '/';
        $current_path = untrailingslashit((string) wp_parse_url($request_uri, PHP_URL_PATH));
        $link_host = wp_parse_url($url, PHP_URL_HOST);
        $link_path = untrailingslashit((string) wp_parse_url($url, PHP_URL_PATH));

        return $link_host === wp_parse_url(home_url(), PHP_URL_HOST) && $link_path === $current_path;
    }
}
