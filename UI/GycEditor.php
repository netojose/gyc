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
        register_block_type($td . '/blocks/call-to-action/block.json');
        register_block_type($td . '/blocks/faq/block.json');
        register_block_type($td . '/blocks/contact-banner/block.json');
        register_block_type($td . '/blocks/registration-options/block.json');
        register_block_type($td . '/blocks/whats-included/block.json');
        register_block_type($td . '/blocks/info-cards/block.json');
        register_block_type($td . '/blocks/image-hero/block.json');
        register_block_type($td . '/blocks/vision/block.json');
        register_block_type($td . '/blocks/mission/block.json');
        register_block_type($td . '/blocks/goals/block.json');
        register_block_type($td . '/blocks/committee/block.json');
    }

    public function allowed_block_types($allowed_blocks, $editor_context)
    {
        if (
            ! empty($editor_context->post) &&
            $editor_context->post->post_type === 'event'
        ) {
            return [
                'gyc/event-hero',
                'gyc/topics',
                'gyc/agenda',
                'gyc/people',
                'gyc/pricing-table',
            ];
        }

        return $allowed_blocks;
    }
}
