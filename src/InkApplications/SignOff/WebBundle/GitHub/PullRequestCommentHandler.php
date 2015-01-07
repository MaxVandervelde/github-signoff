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
 * Handles a Pull-Request Comment payload from a github hook.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class PullRequestCommentHandler implements PayloadHandler
{
    private $statusEndpoint;

    function __construct(StatusEndpoint $statusEndpoint)
    {
        $this->statusEndpoint = $statusEndpoint;
    }

    /**
     * Handle a pull-request comment payload.
     *
     * Checks if the comment body is an approval and sets the status accordingly.
     *
     * @param stdClass $json A json object of a pull-request comment event.
     * @param UserRepository $repository The user repository to modify.
     */
    public function handle(stdClass $json, UserRepository $repository)
    {
        $repoName = $repository->getName();
        $owner = $repository->getOwner();
        $commit = $json->pull_request->head->sha;
        $body = $json->comment->body;

        if ($this->isPeerRejection($body)) {
            $this->statusEndpoint->markFailure(
                $owner,
                $repoName,
                $commit,
                'A peer has rejected this pull request.'
            );
        }

        if ($this->isPeerApproval($body)) {
            $this->statusEndpoint->markSuccessful(
                $owner,
                $repoName,
                $commit,
                'This has been approved by a peer'
            );
        }
    }

    protected function isPeerRejection($body) {
        $rejectionValues = [
            '-1',
            ':-1:',
            'nopenopenope',
        ];

        foreach ($rejectionValues as $value) {
            if (preg_match('/^\s*' . preg_quote($value) . '(?:\s+|$)/i', $body)) {
                return true;
            }
        }

        return false;
    }

    protected function isPeerApproval($body) {
        $approvalValues = [
            '+1',
            ':+1:',
            'seemslegit.biz',
            'lgtm',
        ];

        foreach ($approvalValues as $value) {
            if (preg_match('/^\s*' . preg_quote($value) . '(?:\s+|$)/i', $body)) {
                return true;
            }
        }

        return false;
    }
}
