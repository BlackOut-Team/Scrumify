<?php

namespace MessagingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FriendShip
 *
 * @ORM\Table(name="friend_ship")
 * @ORM\Entity(repositoryClass="MessagingBundle\Repository\FriendShipRepository")
 */
class FriendShip
{
    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     * @ORM\Id
     */
    private $user;

    /**
     * @return int
     */
    public function getIsFriend(): int
    {
        return $this->isFriend;
    }

    /**
     * @param int $isFriend
     */
    public function setIsFriend(int $isFriend): void
    {
        $this->isFriend = $isFriend;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="is_friend", type="integer")
     */
    private $isFriend;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getFriend()
    {
        return $this->friend;
    }

    /**
     * @param mixed $friend
     */
    public function setFriend($friend): void
    {
        $this->friend = $friend;
    }

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="friend_id",referencedColumnName="id")
     * @ORM\Id
     */
    private $friend;
}
