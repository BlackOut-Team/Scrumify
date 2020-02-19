<?php

namespace UserstoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * userstorycomment
 *
 * @ORM\Table(name="userstorycomment")
 * @ORM\Entity(repositoryClass="UserstoryBundle\Repository\userstorycommentRepository")
 */
class userstorycomment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * @ORM\ManyToOne(targetEntity="userstory")
     * @ORM\JoinColumn(name="userstory_id",referencedColumnName="id")
     */
    private $userstory;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $user;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set comment.
     *
     * @param string $comment
     *
     * @return userstorycomment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return userstorycomment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }



    /**
     * Set userstory.
     *
     * @param \UserstoryBundle\Entity\userstory|null $userstory
     *
     * @return userstorycomment
     */
    public function setUserstory(\UserstoryBundle\Entity\userstory $userstory = null)
    {
        $this->userstory = $userstory;

        return $this;
    }

    /**
     * Get userstory.
     *
     * @return \UserstoryBundle\Entity\userstory|null
     */
    public function getUserstory()
    {
        return $this->userstory;
    }

    /**
     * Set user.
     *
     * @param \MainBundle\Entity\User|null $user
     *
     * @return userstorycomment
     */
    public function setUser(\MainBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \MainBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
