<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\GitHub;

use InkApplications\SignOff\Api\GitHub\StatusEndpoint;
use InkApplications\SignOff\WebBundle\Entity\UserRepository;
use stdClass;

/**
 * Handles a Pull-Request event payload from a github hook.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class PullRequestHandler implements PayloadHandler
{
    private $statusEndpoint;

    function __construct(StatusEndpoint $statusEndpoint)
    {
        $this->statusEndpoint = $statusEndpoint;
    }

    /**
     * Handle a pull-request payload.
     *
     * Marks all initial pull-requests as pending.
     *
     * @param stdClass $json A json object of a pull-request comment event.
     * @param UserRepository $repository The user repository to modify.
     */
    public function handle(stdClass $json, UserRepository $repository)
    {
        $repoName = $repository->getName();
        $owner = $repository->getOwner();
        $commit = $json->pull_request->head->sha;

        $this->statusEndpoint->markPending(
            $owner,
            $repoName,
            $commit,
            'Waiting for peer review.'
        );
    }
}
