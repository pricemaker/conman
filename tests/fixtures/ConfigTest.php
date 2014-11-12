<?php

namespace Models\Platform;

use Conman\Resolver\ConfigResolver;
use DateTime;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Yaml\Yaml;


class ConfigTest extends PHPUnit_Framework_TestCase {


    /**
     * @dataProvider configProvider
     */
    public function testGlobals($realm){

        $resolver = new ConfigResolver(['role' => 'test', 'realm' => $realm]);

        $result = $resolver->resolve('test');
        $expected = $this->loadResult($realm);
        $this->assertSame($expected, $result);


    }

    public function configProvider(){
        return array(
            ['global'],
            ['realm1'],
            ['realm2']
        );
    }

    public function loadResult($realm){

        $file = TEST_DIR . '/config/' . $realm . '.json';
        if(!file_exists($file))
            throw new \LogicException("Could not load result file for config realm $realm");

        $contents = file_get_contents($file);
        return json_decode($contents, true);
    }


}