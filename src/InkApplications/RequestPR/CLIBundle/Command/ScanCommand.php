<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\RequestPR\CLIBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Scan the GitHub repositories for approval comments.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class ScanCommand extends Command
{
    protected function configure()
    {
        parent::configure();

        $this->setName('pr:scan');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Hello Wald!");
    }
}
