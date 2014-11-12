<?php

require_once PMK_ROOT . '/vendor/autoload.php';

use Conman\Resolver\ManifestResolver;

$resolver = new ManifestResolver($_GET);
$response = $resolver->resolve($_GET['role']);

header('Content-Type: text/plain');
echo $response;