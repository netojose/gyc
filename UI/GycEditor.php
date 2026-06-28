<?php

if (! defined('ABSPATH')) {
    exit;
}

class GycEditor
{
    public function __construct()
    {
        add_action('init', array($this, 'register_blocks'));
        // add_filter('allowed_block_types_all', array($this, 'allowed_block_types'), 10, 2);
        add_action('current_screen', array($this, 'editor_setup_ui'));
    }

    public function register_blocks()
    {
        register_block_type(get_template_directory() . '/blocks/topics/build/topics/block.json', array('icon' => 'editor-ul'));
        register_block_type(get_template_directory() . '/blocks/agenda/build/agenda/block.json', array('icon' => 'calendar'));
        register_block_type(get_template_directory() . '/blocks/people/build/people/block.json', array('icon' => 'admin-users'));
        register_block_type(get_template_directory() . '/blocks/pricing-table/build/pricing-table/block.json', array('icon' => 'tickets'));
    }

    public function allowed_block_types($allowed_blocks, $editor_context)
    {
        if (
            ! empty($editor_context->post) &&
            $editor_context->post->post_type === 'event'
        ) {
            return [
                'gyc/topics',
                'gyc/agenda',
                'gyc/people',
                'gyc/pricing-table',
            ];
        }

        return $allowed_blocks;
    }

    public function editor_setup_ui()
    {
        $screen = get_current_screen();

        if (! $screen || $screen->post_type !== 'event' || $screen->base !== 'post') {
            return;
        }

        add_theme_support('editor-styles');
        add_editor_style('assets/css/editor-style.css');
    }
}
