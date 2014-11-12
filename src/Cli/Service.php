<?php

namespace Conman\Cli;

use Conman\Resolver\ConfigResolver;
use Conman\Resolver\FileResolver;
use Conman\Resolver\ManifestResolver;
use Symfony\Component\Console\Output\OutputInterface;

class Service {

    /** @var \Symfony\Component\Console\Output\OutputInterface $output */
    private $output;

    public function config($args, $source){

        if($source === 'local'){
            $resolver = new ConfigResolver($args);
            return $resolver->resolve($args['role']);
        }
        else {
            $url = $source . '/config';
            $url .= '?' . http_build_query($args);
            return $this->request($url);
        }

    }

    public function manifest($args, $source) {

        if($source === 'local'){
            $resolver = new ManifestResolver($args);
            return $resolver->resolve($args['role']);
        }
        else {
            $url = $source . '/manifest';
            $url .= '?' . http_build_query($args);
            return $this->request($url);
        }

    }

    public function file($file, $args, $source) {

        if($source === 'local'){
            $resolver = new FileResolver($file, $args);
            return $resolver->resolve($args['role']);
        }
        else {
            $url = $source . '/manifest';
            $url .= '?' . http_build_query($args);
            return $this->request($url);
        }

    }

    private function request($url){
        $contents = file_get_contents($url);
        return json_decode($contents, true);
    }

    private function log($message, $level = null){
        if(!$this->output instanceof OutputInterface)
            return false;

        $type = OutputInterface::OUTPUT_PLAIN;
        if($level !== null){
            $type = OutputInterface::OUTPUT_NORMAL;
            $message = sprintf('<%1$s>%2$s</%1$s>', $level, $message);
        }

        $this->output->writeln($message, $type);
    }

    public function setOutput(OutputInterface $output) {
        $this->output = $output;
    }

}