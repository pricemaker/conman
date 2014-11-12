<?php


namespace Conman\Resolver\Rule;


abstract class AbstractRule {

    public function __construct($name, $match, array $args = array()){
        $this->name = $name;
        $this->match = $match;
        $this->args = $args;
    }

    /**
     * @param $name
     * @param $match
     * @param $args
     *
     * @throws \InvalidArgumentException
     * @return \Conman\Resolver\Rule\AbstractRule
     */
    public static function create($name, $match, $args) {

        $class = sprintf("\\Conman\\Resolver\\Rule\\%sRule", ucfirst($name));
        if(!class_exists($class)){
            $class = "\\Conman\\Resolver\\Rule\\MatchRule";
        }

        return new $class($name, $match, $args);
    }

    abstract public function apply();

}