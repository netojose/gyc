<?php

if (! defined('ABSPATH')) {
    exit;
}

class GycUI
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'setup_assets'));
        add_filter('should_load_separate_core_block_assets', '__return_false', 11);
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
