<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\GitHub;

use SplEnum;

/**
 * An Enumeration of potentially handled types from GitHub's hook payloads.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
final class PayloadType extends SplEnum
{
    const __DEFAULT = self::UNKNOWN;
    const UNKNOWN = 0;
    const PULL_REQUEST_COMMENT = 1;
    const PULL_REQUEST = 2;
}
