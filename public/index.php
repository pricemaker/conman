<?php

use Conman\Resolver\ConfigResolver;
use Conman\Resolver\ManifestResolver;

define('PMK_ROOT', dirname(dirname(__FILE__)));

require_once PMK_ROOT . '/vendor/autoload.php';

chdir(PMK_ROOT);

$mode = 'config';
if(strpos($_SERVER['DOCUMENT_URI'], '/manifest') !== false)
    $mode = 'manifest';

require "public/{$mode}.php";