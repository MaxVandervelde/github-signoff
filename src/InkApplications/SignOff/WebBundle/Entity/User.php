<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User/Login model.
 *
 * @ORM\Entity
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @var string A UUID specific to the local entity.
     */
    protected $id;
}
