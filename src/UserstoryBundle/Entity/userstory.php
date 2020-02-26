<?php

namespace UserstoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * userstory
 *
 * @ORM\Table(name="userstory")
 * @ORM\Entity(repositoryClass="UserstoryBundle\Repository\userstoryRepository")
 */
class userstory
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;

    /**
     * @var int
     *
     * @ORM\Column(name="story_point", type="integer")
     */
    private $storyPoint;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="feature")
     * @ORM\JoinColumn(name="feature_id",referencedColumnName="id")
     */

    private $feature;

    /**
     * @var int
     *
     * @ORM\Column(name="isDeleted", type="integer")
     */
    private $isDeleted;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return userstory
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return userstory
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set storyPoint
     *
     * @param integer $storyPoint
     *
     * @return userstory
     */
    public function setStoryPoint($storyPoint)
    {
        $this->storyPoint = $storyPoint;

        return $this;
    }

    /**
     * Get storyPoint
     *
     * @return int
     */
    public function getStoryPoint()
    {
        return $this->storyPoint;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return userstory
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @return mixed
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * @param mixed $feature
     */
    public function setFeature($feature)
    {
        $this->feature = $feature;
    }


    /**
     * Set isDeleted
     *
     * @param integer $isDeleted
     *
     * @return userstory
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return integer
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }


}
