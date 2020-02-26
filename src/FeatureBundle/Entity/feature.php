<?php

namespace FeatureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * feature
 *
 * @ORM\Table(name="feature")
 * @ORM\Entity(repositoryClass="FeatureBundle\Repository\featureRepository")
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
     * @ORM\Column(name="etat", type="integer", length=255)
     */
    private $etat;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="SprintBundle\Entity\Sprint")
     * @ORM\JoinColumn(name="sprint_id",referencedColumnName="id")
     */
    private $sprint;

    /**
     * @return mixed
     */
    public function getSprint()
    {
        return $this->sprint;
    }

    /**
     * @param mixed $sprint
     */
    public function setSprint($sprint)
    {
        $this->sprint = $sprint;
    }

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
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }
}

