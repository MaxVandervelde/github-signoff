<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\CLIBundle\Command;

use InkApplications\SignOff\Api\GitHub\StatusEndpoint;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Change the status of a commit via a command line operation.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class StatusCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('signoff:status');
        $this->addArgument('owner', InputArgument::REQUIRED, 'The user/organization that owns the repository');
        $this->addArgument('repository', InputArgument::REQUIRED, 'The repository the commit belongs to');
        $this->addArgument('commit', InputArgument::REQUIRED, 'The commit to change the status of');
        $this->addArgument('status', InputArgument::REQUIRED, 'status to set on the commit any of: [success, fail, pending]');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $owner = $input->getArgument('owner');
        $repository = $input->getArgument('repository');
        $commit = $input->getArgument('commit');
        $status = $input->getArgument('status');

        /** @var StatusEndpoint $api */
        $api = $this->getContainer()->get('github.endpoint.statuses');

        switch ($status) {
            case 'success':
            case 'approve':
                $api->markSuccessful($owner, $repository, $commit);
                break;
            case 'failure':
            case 'fail':
                $api->markFailure($owner, $repository, $commit);
                break;
            case 'pending':
            case 'indeterminate':
                $api->markPending($owner, $repository, $commit);
                break;
            default:
                $output->writeln('<error>Error: Status must be success, failure, or pending</error>');
        }
    }
}
