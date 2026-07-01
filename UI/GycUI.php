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
            get_template_directory_uri() . '/build/styles.css',
            array(),
            filemtime(get_template_directory() . '/build/styles.css')
        );

        wp_enqueue_script(
            'gyc-scripts',
            get_template_directory_uri() . '/build-site/app.js',
            array(),
            filemtime(get_template_directory() . '/build-site/app.js'),
            true
        );
    }
}
