<?php


namespace Conman\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Dumper;

class ConfigCommand extends Command {

    protected function configure() {
        $this
            ->setName('config')
            ->setDescription('Get the config for a role')
            ->addOption('role', 'r', InputOption::VALUE_REQUIRED, 'The role to fetch the config for')
            ->addOption('realm', 'm', InputOption::VALUE_OPTIONAL, 'The provisioning realm for the config', 'production')
            ->addOption('arg', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Optional additional arguments')
            ->addOption('format', 'f', InputOption::VALUE_OPTIONAL, 'The output file format', 'json')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        /** @var \Conman\Cli\Service $service */
        $service = $this->getApplication()->getService();

        $service->setOutput($output);

        $args = $input->getOption('arg');
        $args['role'] = $input->getOption('role');
        $args['realm'] = $input->getOption('realm');

        $config = $service->config($args, $input->getOption('base'));

        $format = $input->getOption('format');
        $saved = $this->serialize($config, $format);

        $output->write($saved, true, OutputInterface::OUTPUT_PLAIN);
    }

    private function serialize($config, $format){

        $serialized = null;

        switch($format){
            case 'json':
                $serialized = json_encode($config);
                break;
            case 'php':
                $content = var_export($config, true);
                $serialized = "<?php\nreturn $content";
                break;
            case 'yaml':
                $dumper = new Dumper();
                $serialized = $dumper->dump($config, 3);
                break;
            default:
                throw new \RuntimeException("Unknown output format {$format}");
        }

        return $serialized;
    }
}