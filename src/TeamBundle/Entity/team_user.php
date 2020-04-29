<?php

namespace TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * team_user
 *
 * @ORM\Table(name="team_user")
 * @ORM\Entity(repositoryClass="TeamBundle\Repository\team_userRepository")
 */
class team_user
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="TeamBundle\Entity\Team")
     * @ORM\JoinColumn(name="team_id",referencedColumnName="id")
     */
    private $teamId;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $userId;



    /**
     * Set teamId.
     *
     * @param int $teamId
     *
     * @return team_user
     */
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;

        return $this;
    }

    /**
     * Get teamId.
     *
     * @return int
     */
    public function getTeamId()
    {
        return $this->teamId;
    }

    /**
     * Set userId.
     *
     * @param int $userId
     *
     * @return team_user
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="role", type="integer")
     */
    private $role;

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole(int $role): void
    {
        $this->role = $role;
    }

}
