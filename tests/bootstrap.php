<?php

error_reporting(E_ALL | E_STRICT);

date_default_timezone_set('UTC');

define('PMK_ROOT', dirname(dirname(__FILE__)));
chdir(PMK_ROOT);

define('TEST_DIR', __DIR__);
define('VENDOR_DIR', dirname(TEST_DIR) . '/vendor');

// Ensure that composer has installed all dependencies
if (!file_exists(dirname(__DIR__) . '/composer.lock')) {
    die("Dependencies must be installed using composer:\n\nphp composer.phar install --dev\n\n"
        . "See http://getcomposer.org for help with installing composer\n");
}

// Include the composer autoloader
$loader = require VENDOR_DIR. '/autoload.php';
$loader->add('', TEST_DIR . '/fixtures');
