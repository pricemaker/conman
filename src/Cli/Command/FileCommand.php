<?php


namespace Conman\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Dumper;

class FileCommand extends Command {

    protected function configure() {
        $this
            ->setName('file')
            ->setDescription('Get a file for a role')
            ->addArgument('file', InputArgument::REQUIRED, 'The name of the file to load')
            ->addOption('role', 'r', InputOption::VALUE_REQUIRED, 'The role to fetch the file for')
            ->addOption('realm', 'm', InputOption::VALUE_OPTIONAL, 'The provisioning realm for the file', 'production')
            ->addOption('arg', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Optional additional arguments')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        /** @var \Conman\Cli\Service $service */
        $service = $this->getApplication()->getService();
        $service->setOutput($output);

        $args = $input->getOption('arg');
        $args['role'] = $input->getOption('role');
        $args['realm'] = $input->getOption('realm');

        $file = $input->getArgument('file');

        $manifest = $service->file($file, $args, $input->getOption('base'));

        $output->write($manifest, true, OutputInterface::OUTPUT_PLAIN);
    }

}