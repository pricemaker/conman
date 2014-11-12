<?php

namespace Conman\Resolver;

use Closure;
use Conman\Resolver\Rule\AbstractRule;

abstract class Resolver {

    protected $base;

    private static $rule_defaults = array(
        'match' => [],
        'terminal' => false,
        'inherit' => true,
        'target' => 'default'
    );

    public function __construct(array $args = array()){
        $this->args = $args;
    }

    abstract public function resolve($role);
    abstract protected function apply($role, $target, $rule);

    protected function applyRules($role){
        $rules = $this->loadRules($role);

        foreach($rules as $rule){
            $target = $rule['target'];
            $matches = true;
            foreach($rule['match'] as $name => $match){
                if($name === 'target') continue;

                $evaluate = AbstractRule::create($name, $match, $this->args);
                if(!$evaluate->apply()){
                    $matches = false;
                    break;
                }
            }

            if($matches) $this->apply($role, $target, $rule);
        }

        return $rules;
    }

    protected function loadConfigSource($role, $file){
        $source = $this->base . DIRECTORY_SEPARATOR . $role . DIRECTORY_SEPARATOR . $file . '.php';

        if(!file_exists($source))
            return array();

        return include $source;
    }

    private function loadRules($role){
        $source = $this->loadConfigSource($role, 'rules');
        $rules = array();
        foreach($source as $rule){
            $rules[] = array_replace(self::$rule_defaults, $rule);
        }
        return $rules;
    }

}