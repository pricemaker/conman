<?php


return array(
    'key1' => 'value1',
    'key2' => array(
        'subkey1' => 'subvalue1',
        'nullable' => null,
        'callable' => function(){
                return 'callable result';
            }
    ),
    'globals' => array(
        'test_key' => $this->globals['test']['test_key']
    )
);