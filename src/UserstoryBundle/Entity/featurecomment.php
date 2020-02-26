<?php

namespace UserstoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * featurecomment
 *
 * @ORM\Table(name="featurecomment")
 * @ORM\Entity(repositoryClass="UserstoryBundle\Repository\featurecommentRepository")
 */
class featurecomment
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
     * @ORM\ManyToOne(targetEntity="feature")
     * @ORM\JoinColumn(name="feature_id",referencedColumnName="id")
     */
    private $feature;

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
     * @return featurecomment
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
     * @return featurecomment
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
     * Set feature.
     *
     * @param \UserstoryBundle\Entity\feature|null $feature
     *
     * @return featurecomment
     */
    public function setFeature(\UserstoryBundle\Entity\feature $feature = null)
    {
        $this->feature = $feature;

        return $this;
    }

    /**
     * Get feature.
     *
     * @return \UserstoryBundle\Entity\feature|null
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Set user.
     *
     * @param \MainBundle\Entity\User|null $user
     *
     * @return featurecomment
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
