<?php

namespace Blog\Entity;

use ZfcUser\Entity\User as ZfcUserEntity;
use ZfcRbac\Identity\IdentityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends ZfcUserEntity implements IdentityInterface
{
    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return 'user';
    }

}