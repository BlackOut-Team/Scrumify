<?php

namespace UserstoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * feature
 *
 * @ORM\Table(name="feature")
 * @ORM\Entity(repositoryClass="UserstoryBundle\Repository\featureRepository")
 */
class feature
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;




    /**
     * @var int
     *
     * @ORM\Column(name="isDeleted", type="integer")
     */
    private $isDeleted;

    /**
     * @ORM\ManyToOne(targetEntity="SprintBundle\Entity\Sprint")
     * @ORM\JoinColumn(name="sprint_id",referencedColumnName="id")
     */

    private $sprint;
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
     * Set name
     *
     * @param string $name
     *
     * @return feature
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return feature
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

    public function __toString()
    {
        return $this->name;
        // TODO: Implement __toString() method.
    }


    /**
     * Set isDeleted.
     *
     * @param int $isDeleted
     *
     * @return feature
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted.
     *
     * @return int
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }



    /**
     * Set sprint.
     *
     * @param \SprintBundle\Entity\Sprint|null $sprint
     *
     * @return feature
     */
    public function setSprint(\SprintBundle\Entity\Sprint $sprint = null)
    {
        $this->sprint = $sprint;

        return $this;
    }

    /**
     * Get sprint.
     *
     * @return \SprintBundle\Entity\Sprint|null
     */
    public function getSprint()
    {
        return $this->sprint;
    }
}