<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Clears the page cache when the open price box of the Registration Options block
 * (blocks/registration-options) changes, so cached pages never show an old price.
 *
 * A box opens at 00:00 on its "Opens on" date and closes at 00:00 after its "Last day",
 * in the site timezone. One WP-Cron event is scheduled for each of those moments.
 */
class GycRegistration
{
    const BLOCK = 'gyc/registration-options';
    const SWITCH_HOOK = 'gyc_registration_switch';
    const CHECKED_TRANSIENT = 'gyc_registration_switch_checked';

    public function __construct()
    {
        add_action(self::SWITCH_HOOK, array($this, 'purge_page_cache'));
        add_action('init', array($this, 'maybe_reschedule'), 20);
        add_action('save_post', array($this, 'on_save_post'), 10, 2);
        add_action('after_switch_theme', array($this, 'reschedule'));
    }

    /**
     * Rechecks the schedule once a day, which also picks up dates that only exist
     * in the theme's template files and have never been saved in the editor.
     */
    public function maybe_reschedule()
    {
        if (! get_transient(self::CHECKED_TRANSIENT)) {
            $this->reschedule();
        }
    }

    /**
     * Saving a template or page that contains the block can change the dates or the
     * "Which box is open" setting, so reschedule and show the change straight away.
     */
    public function on_save_post($post_id, $post)
    {
        if (wp_is_post_revision($post_id) || strpos((string) $post->post_content, '<!-- wp:' . self::BLOCK) === false) {
            return;
        }

        $this->reschedule();
        $this->purge_page_cache();
    }

    public function reschedule()
    {
        wp_clear_scheduled_hook(self::SWITCH_HOOK);

        foreach ($this->switch_times() as $timestamp) {
            wp_schedule_single_event($timestamp, self::SWITCH_HOOK);
        }

        set_transient(self::CHECKED_TRANSIENT, 1, DAY_IN_SECONDS);
    }

    /**
     * Future timestamps at which a price box opens or closes.
     */
    public function switch_times()
    {
        $times = array();
        $now = time();

        foreach ($this->find_items() as $item) {
            if (! empty($item['start'])) {
                $times[] = $this->midnight($item['start'], 0);
            }
            if (! empty($item['end'])) {
                $times[] = $this->midnight($item['end'], 1);
            }
        }

        $times = array_filter(array_unique($times), function ($timestamp) use ($now) {
            return $timestamp && $timestamp > $now;
        });
        sort($times);

        return $times;
    }

    /**
     * Clears the page cache of common caching plugins and hosts. Each call is skipped
     * when that plugin isn't installed. For anything else, hook into "gyc_registration_switch".
     */
    public function purge_page_cache()
    {
        if (function_exists('rocket_clean_domain')) {
            rocket_clean_domain(); // WP Rocket
        }
        if (function_exists('w3tc_flush_all')) {
            w3tc_flush_all(); // W3 Total Cache
        }
        if (function_exists('wp_cache_clear_cache')) {
            wp_cache_clear_cache(); // WP Super Cache
        }
        if (function_exists('wpfc_clear_all_cache')) {
            wpfc_clear_all_cache(true); // WP Fastest Cache
        }
        if (function_exists('sg_cachepress_purge_cache')) {
            sg_cachepress_purge_cache(); // SiteGround
        }
        if (class_exists('WpeCommon')) {
            if (method_exists('WpeCommon', 'purge_memcached')) {
                WpeCommon::purge_memcached(); // WP Engine
            }
            if (method_exists('WpeCommon', 'purge_varnish_cache')) {
                WpeCommon::purge_varnish_cache();
            }
        }
        do_action('litespeed_purge_all'); // LiteSpeed Cache
        do_action('cache_enabler_clear_complete_cache'); // Cache Enabler
        do_action('breeze_clear_all_cache'); // Breeze (Cloudways)
        do_action('wphb_clear_page_cache'); // Hummingbird

        wp_cache_flush();
    }

    /**
     * Price boxes of every Registration Options block in templates and published content.
     */
    private function find_items()
    {
        global $wpdb;

        $contents = array();

        foreach (get_block_templates(array(), 'wp_template') as $template) {
            $contents[] = $template->content;
        }

        $contents = array_merge($contents, $wpdb->get_col($wpdb->prepare(
            "SELECT post_content FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type NOT IN ('wp_template', 'revision') AND post_content LIKE %s",
            '%' . $wpdb->esc_like('<!-- wp:' . self::BLOCK) . '%'
        )));

        $block_type = WP_Block_Type_Registry::get_instance()->get_registered(self::BLOCK);
        $default_items = ($block_type && isset($block_type->attributes['items']['default'])) ? $block_type->attributes['items']['default'] : array();

        $items = array();
        foreach ($contents as $content) {
            if (strpos((string) $content, '<!-- wp:' . self::BLOCK) === false) {
                continue;
            }
            foreach ($this->find_blocks(parse_blocks($content)) as $block) {
                $block_items = isset($block['attrs']['items']) ? $block['attrs']['items'] : $default_items;
                $items = array_merge($items, (array) $block_items);
            }
        }

        return $items;
    }

    private function find_blocks($blocks)
    {
        $found = array();

        foreach ($blocks as $block) {
            if ($block['blockName'] === self::BLOCK) {
                $found[] = $block;
            }
            if (! empty($block['innerBlocks'])) {
                $found = array_merge($found, $this->find_blocks($block['innerBlocks']));
            }
        }

        return $found;
    }

    /**
     * Midnight at the start of a "Y-m-d" date plus $add_days, in the site timezone.
     */
    private function midnight($date, $add_days)
    {
        $day = DateTimeImmutable::createFromFormat('!Y-m-d', (string) $date, wp_timezone());

        if (! $day) {
            return null;
        }

        return $day->modify('+' . (int) $add_days . ' day')->getTimestamp();
    }
}
