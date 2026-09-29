<?php

require_once get_template_directory() . '/UI/GycEvent.php';
require_once get_template_directory() . '/UI/GycEditor.php';
require_once get_template_directory() . '/UI/GycUI.php';
require_once get_template_directory() . '/UI/GycRegistration.php';

new GycEvent();
new GycEditor();
new GycUI();
new GycRegistration();
