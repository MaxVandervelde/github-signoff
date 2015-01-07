<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\GitHub;

use JMS\DiExtraBundle\Annotation\Service;
use stdClass;

/**
 * Identifies the type of payload from a posted json body of a GitHub hook.
 *
 * @Service("payload_identifier")
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class PayloadIdentifier
{
    /**
     * Identifies a posted json body from a GitHub hook as a specific payload type.
     *
     * @param stdClass $json The decoded json array posted by a github hook.
     * @return PayloadType The associated payload type, or UNKNOWN if one could
     *     not be identified from the json.
     */
    public function getPayloadType(stdClass $json)
    {
        if (isset($json->comment) && isset($json->pull_request)) {
            return new PayloadType(PayloadType::PULL_REQUEST_COMMENT);
        } else if (isset($json->pull_request)) {
            return new PayloadType(PayloadType::PULL_REQUEST);
        } else {
            return new PayloadType(PayloadType::UNKNOWN);
        }
    }
}
