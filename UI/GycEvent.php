<?php

if (! defined('ABSPATH')) {
    exit;
}

class GycEvent
{
    public function __construct()
    {
        add_action('init', array($this, 'setup_post_type'), 0);
    }

    public function setup_post_type()
    {
        $labels = array(
            'name'                  => _x('Events', 'Post Type General Name', 'text_domain'),
            'singular_name'         => _x('Event', 'Post Type Singular Name', 'text_domain'),
            'menu_name'             => __('Events', 'text_domain'),
            'name_admin_bar'        => __('Event', 'text_domain'),
            'archives'              => __('Events list', 'text_domain'),
            'attributes'            => __('Event attributes', 'text_domain'),
            'parent_item_colon'     => __('Parent event:', 'text_domain'),
            'all_items'             => __('All events', 'text_domain'),
            'add_new_item'          => __('Add New event', 'text_domain'),
            'add_new'               => __('Add new', 'text_domain'),
            'new_item'              => __('New event', 'text_domain'),
            'edit_item'             => __('Edit event', 'text_domain'),
            'update_item'           => __('Update event', 'text_domain'),
            'view_item'             => __('View event', 'text_domain'),
            'view_items'            => __('View events', 'text_domain'),
            'search_items'          => __('Search event', 'text_domain'),
            'not_found'             => __('Not found', 'text_domain'),
            'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
            'featured_image'        => __('Featured Image', 'text_domain'),
            'set_featured_image'    => __('Set featured image', 'text_domain'),
            'remove_featured_image' => __('Remove featured image', 'text_domain'),
            'use_featured_image'    => __('Use as featured image', 'text_domain'),
            'insert_into_item'      => __('Insert into event', 'text_domain'),
            'uploaded_to_this_item' => __('Uploaded to this event', 'text_domain'),
            'items_list'            => __('Events list', 'text_domain'),
            'items_list_navigation' => __('Events list navigation', 'text_domain'),
            'filter_items_list'     => __('Filter events list', 'text_domain'),
        );

        $args = array(
            'label'                 => __('Event', 'text_domain'),
            'description'           => __('Events', 'text_domain'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor'),
            'show_in_rest'          => true,
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-tickets',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );

        register_post_type('event', $args);
    }
}
