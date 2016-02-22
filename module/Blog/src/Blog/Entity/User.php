<?php

namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use ZfcUser\Entity\User as ZfcUserEntity;
use ZfcRbac\Identity\IdentityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends ZfcUserEntity implements IdentityInterface
{
//    /**
//     * @OneToMany(targetEntity="Blog\Entity\Article",mappedBy="user")
//     */
//    private $articles;

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return 'user';
    }

}