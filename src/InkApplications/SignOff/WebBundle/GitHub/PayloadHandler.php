<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\GitHub;

use InkApplications\SignOff\WebBundle\Entity\UserRepository;
use stdClass;

/**
 * A strategy definition for handling payloads of a specific `PayloadType` as
 * sent by GitHub.
 *
 * @see PayloadType
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
interface PayloadHandler
{
    public function handle(stdClass $json, UserRepository $repository);
}
