<?php

require_once PMK_ROOT . '/vendor/autoload.php';

use Conman\Resolver\ConfigResolver;

$resolver = new ConfigResolver($_GET);
$config = $resolver->resolve($_GET['role']);
$format = isset($_GET['format']) ? $_GET['format'] : 'json';

$status = 200;
if(isset($config['_error'])){
    $status = (isset($config['_error']['code']) ? $config['_error']['code'] : 200);
    $response = array(
        'error' => isset($config['_error']['status']) ? $config['_error']['status'] : '',
        'error_description' => isset($config['_error']['message']) ? $config['_error']['message'] : ''
    );
}
else {
    $response = $config;
}

http_response_code($status);

switch($format){
    case 'json':
        header('Content-Type: application/json');
        echo json_encode($response, true);
        break;
    case 'yaml':
        header('Content-Type: text/x-yaml');
        $dumper = new \Symfony\Component\Yaml\Dumper();
        echo $dumper->dump($response, 3);
        break;
    default:
        echo "Unknown output format {$format}";
        http_response_code(500);
}
