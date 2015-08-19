<?php


namespace Conman\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Dumper;

class ManifestCommand extends Command {

    protected function configure() {
        $this
            ->setName('manifest')
            ->setDescription('Get the config for a role')
            ->addOption('role', 'r', InputOption::VALUE_REQUIRED, 'The role to fetch the config for')
            ->addOption('realm', 'm', InputOption::VALUE_OPTIONAL, 'The provisioning realm for the config', 'production')
            ->addOption('ref', 'f', InputOption::VALUE_OPTIONAL, 'The provisioning ref for the config', 'production')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        /** @var \Conman\Cli\Service $service */
        $service = $this->getApplication()->getService();
        $service->setOutput($output);

        $manifest = $service->manifest($input->getOptions(), $input->getOption('base'));

        $output->write($manifest, true, OutputInterface::OUTPUT_PLAIN);
    }

}