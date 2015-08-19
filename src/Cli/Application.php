<?php


namespace Conman\Cli;


use Conman\Cli\Command\ConfigCommand;
use Conman\Cli\Command\FileCommand;
use Conman\Cli\Command\ManifestCommand;
use Conman\Cli\Command\SelfUpdateCommand;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Input\InputOption;

class Application extends SymfonyApplication {

    protected $service;

    public function __construct($name = 'conman', $version = '0.0.1') {
        parent::__construct($name, $version);

        $this->service = new Service();

        $this->addCommands([
            new ManifestCommand(),
            new ConfigCommand(),
            new FileCommand(),
            new SelfUpdateCommand()
        ]);

        $this->getDefinition()->addOptions([
            new InputOption('base', 'b', InputOption::VALUE_OPTIONAL,
                'The base URL for the conman installation',
                'local'
            )
        ]);

    }

    public function getService(){
        if(!isset($this->service))
            $this->service = new Service();

        return $this->service;
    }

}