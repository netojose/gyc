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
}
