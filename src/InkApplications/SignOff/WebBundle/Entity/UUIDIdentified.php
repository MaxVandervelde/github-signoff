<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait for models that have a local ID as a generated UUID.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
trait UUIDIdentified
{
    /**
     * Local Identifier for the repository.
     *
     * @ORM\Column(type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @var string A UUID specific to the local entity.
     */
    private $id;

    /**
     * Get the local Identifier for the repository.
     *
     * @return string A UUID specific to the local entity.
     */
    final public function getId()
    {
        return $this->id;
    }

    /**
     * Set the local Identifier for the repository.
     *
     * @param string $id A UUID specific to the local entity.
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
