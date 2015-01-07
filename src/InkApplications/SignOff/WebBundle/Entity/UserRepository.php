<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model of a user's GitHub Repository.
 *
 * @ORM\Entity
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class UserRepository
{
    use UUIDIdentified;

    /**
     * The account that owns the repository, either a user or an organization.
     *
     * @ORM\Column(type="string")
     * @var string
     */
    private $owner;

    /**
     * The name/identifier of the Repository on GitHub.
     *
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @var User
     */
    private $createdBy;

    /**
     * @return string The account that owns the repository, either a user or an organization.
     */
    final public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner The account that owns the repository, either a user
     *     or an organization.
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string The name/identifier of the Repository on GitHub.
     */
    final public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name The name/identifier of the Repository on GitHub.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return User The local user that created and owns this Entity.
     */
    final public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy The local user that created and owns this Entity.
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
}
