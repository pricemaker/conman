<?php

namespace Conman\Resolver;


use Rhumsaa\Uuid\Uuid;

class FileResolver extends Resolver {

    public $file;

    protected $base = 'files';

    public function __construct($file, array $args = array()) {
        $this->file = $file;
        $this->target = 'default';
        parent::__construct($args);
    }


    public function resolve($role) {
        $this->applyRules($role);
        $file = $this->process(
            $role,
            $this->target . DIRECTORY_SEPARATOR . $this->file,
            $role,
            'default' . DIRECTORY_SEPARATOR . $this->file
        );
        return $file;
    }

    protected function apply($role, $target, $rule) {
        $this->target = $target;
    }

    protected function loadFile($role, $file){
        $source = $this->base . DIRECTORY_SEPARATOR . $role . DIRECTORY_SEPARATOR . $file;

        if(!file_exists($source))
            return '';

        return file_get_contents($source);
    }

    protected function process($role, $file, $default_role = null, $default_file = null){
        $contents = $this->loadFile($role, $file);
        if(empty($contents) && $default_role !== null && $default_file !== null)
            $contents = $this->loadFile($default_role, $default_file);

        $keys = array_map(function($key){ return "%{$key}%"; }, array_keys($this->args));
        $contents = str_replace($keys, $this->args, $contents);

        return $contents;

    }

}