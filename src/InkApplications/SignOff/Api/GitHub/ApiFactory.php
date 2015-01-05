<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\Api\GitHub;

use Github\Api\Repo;
use Github\Api\Repository\Statuses;
use Github\Client;

/**
 * Static Factory for creating our GitHub client library services.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
final class ApiFactory
{
    /**
     * Creates a GitHub client that is authenticated with a User's token so that
     * we may access their repos and reduce rate limit errors.
     *
     * @param string $token a GitHub User's API token to be used for all requests.
     * @return Client An API client that has been authenticated with a user token.
     */
    public static function createAuthenticatedApi($token)
    {
        $client = new Client();
        $client->authenticate($token, null, Client::AUTH_HTTP_TOKEN);

        return $client;
    }

    /**
     * Provides the Statuses API out of an authenticated client.
     *
     * @param Client $client An Authenticated API client to use for requests.
     * @return Statuses
     */
    public static function createStatusesApi(Client $client)
    {
        /** @var Repo $repoApi */
        $repoApi = $client->api('repo');

        return $repoApi->statuses();
    }
}
