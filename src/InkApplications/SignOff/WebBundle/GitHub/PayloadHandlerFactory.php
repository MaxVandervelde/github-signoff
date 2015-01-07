<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\GitHub;

use InkApplications\SignOff\Api\GitHub\StatusEndpoint;
use JMS\DiExtraBundle\Annotation as DI;
use stdClass;

/**
 * Gets the correct handler strategy based on a given json payload body's type.
 *
 * @DI\Service("payload_handler_factory")
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class PayloadHandlerFactory
{
    private $identifier;
    private $statusEndpoint;

    /**
     * @DI\InjectParams({
     *     "identifier" = @DI\Inject("payload_identifier"),
     *     "statusEndpoint" = @DI\Inject("github.endpoint.statuses")
     * })
     */
    function __construct(PayloadIdentifier $identifier, StatusEndpoint $statusEndpoint)
    {
        $this->identifier = $identifier;
        $this->statusEndpoint = $statusEndpoint;
    }

    /**
     * Get the correct handler strategy based on a given json payload body's type.
     *
     * @param stdClass $json The json to react to the type of.
     * @throws UnhandledPayloadException If a handler is not available for the type.
     * @return PayloadHandler The handler able to use the json.
     */
    public function getHandler(stdClass $json)
    {
        $type = $this->identifier->getPayloadType($json);
        switch ($type) {
            case PayloadType::PULL_REQUEST_COMMENT:
                return new PullRequestCommentHandler($this->statusEndpoint);
                break;
            case PayloadType::PULL_REQUEST:
                return new PullRequestHandler($this->statusEndpoint);
                break;
            case PayloadType::UNKNOWN:
            default:
                throw new UnhandledPayloadException("No handler setup for payload");
        }
    }
}
