<?php

namespace Conman\Resolver\Rule;


class MatchRule extends AbstractRule {

    public function apply() {
        if(!isset($this->args[$this->name])) return false;
        else return strcmp($this->match, $this->args[$this->name]) === 0;
    }
}