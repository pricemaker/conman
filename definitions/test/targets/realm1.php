<?php


return array(
    'key1' => 'realm1 value1',
    'key2' => array(
        'callable2' => function(){
                return 'callable result 2';
            }
    ),
    'defaults' => array(
        'test_key' => $this->defaults['key2']['subkey1']
    ),
    'child_only' => 'realm1 child value'
);