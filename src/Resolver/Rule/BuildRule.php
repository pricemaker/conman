<?php

namespace Conman\Resolver\Rule;


class BuildRule extends AbstractRule {


    public function apply() {

        if(!isset($this->args['build'])) return false;

        $target = $this->args['build'];

        $comparator = '';
        if($this->match[0] === '>' || $this->match[0] === '<'){
            $comparator = $this->match[0];
            $this->match = substr($this->match, 1);
        }

        if($this->match[0] === '='){
            $comparator .= '=';
            $this->match = substr($this->match, 1);
        }

        if(empty($comparator))
            $comparator = '=';

        return version_compare($target, $this->match, $comparator);

    }
}