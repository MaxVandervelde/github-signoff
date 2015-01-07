<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\Api\GitHub;

use Github\Api\Repository\Statuses;

/**
 * Provides a local API for operations with the GitHub Statuses for a repo.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class StatusEndpoint
{
    const CONTEXT = 'Signoff';

    /**
     * @var Statuses
     */
    private $client;

    /**
     * @param Statuses $client An authenticated github api client for the
     *     statuses endpoint
     */
    public function __construct(Statuses $client)
    {
        $this->client = $client;
    }

    public function markSuccessful($owner, $repo, $commit, $description = null)
    {
        $this->client->create(
            $owner,
            $repo,
            $commit,
            [
                'state' => 'success',
                'context' => self::CONTEXT,
                'description' => $description,
            ]
        );
    }

    public function markFailure($owner, $repo, $commit, $description = null)
    {
        $this->client->create(
            $owner,
            $repo,
            $commit,
            [
                'state' => 'failure',
                'context' => self::CONTEXT,
                'description' => $description,
            ]
        );
    }

    public function markPending($owner, $repo, $commit, $description = null)
    {
        $this->client->create(
            $owner,
            $repo,
            $commit,
            [
                'state' => 'pending',
                'context' => self::CONTEXT,
                'description' => $description,
            ]
        );
    }
}
