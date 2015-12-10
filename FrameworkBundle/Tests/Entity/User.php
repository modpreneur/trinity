<?php


namespace Trinity\FrameworkBundle\Test\Entity;


use Doctrine\ORM\Mapping as ORM;
use Trinity\FrameworkBundle\Entity\BaseUser;


/**
 * User.
 *
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{

}