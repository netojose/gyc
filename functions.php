<?php

require_once get_template_directory() . '/UI/GycUi.php';
require_once get_template_directory() . '/UI/GycEvent.php';
require_once get_template_directory() . '/UI/GycEditor.php';

new GycUi();
new GycEvent();
new GycEditor();

function my_theme_enqueue_block_editor_components_styles()
{
    // Enqueue the built-in WordPress components stylesheet
    wp_enqueue_style('wp-components');
}
add_action('enqueue_block_editor_assets', 'my_theme_enqueue_block_editor_components_styles');
