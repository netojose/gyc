<?php

if (! defined('ABSPATH')) {
    exit;
}

class GycEditor
{
    public function __construct()
    {
        add_action('init', array($this, 'register_blocks'));
        add_filter('allowed_block_types_all', array($this, 'allowed_block_types'), 10, 2);
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_page_settings'));
    }

    /**
     * Sidebar panel for pages and events with the dark header and footer toggle (editor/page-settings).
     */
    public function enqueue_page_settings()
    {
        $screen = function_exists('get_current_screen') ? get_current_screen() : null;
        if (! $screen || ! in_array($screen->post_type, GycUI::DARK_CHROME_POST_TYPES, true)) {
            return;
        }

        $asset_file = get_template_directory() . '/build/page-settings.asset.php';
        if (! file_exists($asset_file)) {
            return;
        }

        $asset = require $asset_file;
        wp_enqueue_script(
            'gyc-page-settings',
            get_template_directory_uri() . '/build/page-settings.js',
            $asset['dependencies'],
            $asset['version'],
            true
        );
    }

    public function register_blocks()
    {
        $td = get_template_directory();
        register_block_type($td . '/blocks/topics/block.json');
        register_block_type($td . '/blocks/agenda/block.json');
        register_block_type($td . '/blocks/people/block.json');
        register_block_type($td . '/blocks/pricing-table/block.json');
        register_block_type($td . '/blocks/hero/block.json');
        register_block_type($td . '/blocks/about-us/block.json');
        register_block_type($td . '/blocks/video/block.json');
        register_block_type($td . '/blocks/community/block.json');
        register_block_type($td . '/blocks/header/block.json');
        register_block_type($td . '/blocks/footer/block.json');
        register_block_type($td . '/blocks/event-hero/block.json');
        register_block_type($td . '/blocks/page-hero/block.json');
        register_block_type($td . '/blocks/why-give/block.json');
        register_block_type($td . '/blocks/gift-options/block.json');
        register_block_type($td . '/blocks/faq/block.json');
        register_block_type($td . '/blocks/contact-banner/block.json');
        register_block_type($td . '/blocks/image-hero/block.json');
        register_block_type($td . '/blocks/vision/block.json');
        register_block_type($td . '/blocks/vision-statement/block.json');
        register_block_type($td . '/blocks/mission/block.json');
        register_block_type($td . '/blocks/goals/block.json');
        register_block_type($td . '/blocks/focus/block.json');
        register_block_type($td . '/blocks/committee/block.json');
        register_block_type($td . '/blocks/spirit/block.json');
        register_block_type($td . '/blocks/volunteer/block.json');
        register_block_type($td . '/blocks/events-overview/block.json');
        register_block_type($td . '/blocks/contact/block.json');
        register_block_type($td . '/blocks/event-modal/block.json');
        register_block_type($td . '/blocks/countdown/block.json');
    }

    public function allowed_block_types($allowed_blocks, $editor_context)
    {
        if (
            ! empty($editor_context->post) &&
            $editor_context->post->post_type === 'event'
        ) {
            return [
                'gyc/event-hero',
                'gyc/countdown',
                'gyc/topics',
                'gyc/agenda',
                'gyc/people',
                'gyc/pricing-table',
            ];
        }

        return $allowed_blocks;
    }
}
