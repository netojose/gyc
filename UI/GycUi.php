<?php

if (! defined('ABSPATH')) {
    exit;
}

class GycUI
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'setup_assets'));
    }

    public function setup_assets()
    {
        //
    }
}
