<?php

namespace Conman\Cli\Command;

use Herrera\Phar\Update\Manager;
use Herrera\Phar\Update\Manifest;
use Aws\S3\S3Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SelfUpdateCommand extends Command
{
    const MANIFEST_FILE = 's3://example-bucket/manifest.json';

    protected function configure() {
        $this
            ->setName('self-update')
            ->setDescription('Updates conman.phar to the latest version')
            ->addOption('aws_key_id', 'k', InputOption::VALUE_OPTIONAL, 'An AWS access key id to use when updating conman')
            ->addOption('aws_secret_key', 's', InputOption::VALUE_OPTIONAL, 'An AWS secret key to use when updating conman')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $aws_options = [
            'region' => 'ap-southeast-2', 'version' => 'latest'
        ];

        if($input->hasArgument('aws_key_id')) {
            $aws_options['credentials'] = [
                'aws_access_key_id' => $input->getOption('aws_key_id'),
                'aws_secret_access_key' => $input->getOption('aws_secret_key')
            ];
        }

        $client = new S3Client($aws_options);
        $client->registerStreamWrapper();

        $manager = new Manager(Manifest::loadFile(self::MANIFEST_FILE));
        $result = $manager->update($this->getApplication()->getVersion(), true);

        if($result)
            $output->write('Conman was updated to a new version', true);
        else
            $output->Write('Conman is already at the latest version', true);

    }
}
