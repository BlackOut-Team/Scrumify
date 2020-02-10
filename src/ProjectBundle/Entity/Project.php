<?php

namespace ProjectBundle\Entity;

/**
 * Project
 */
class Project
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $created;
    /**
     * @var \DateTime
     */
    private $duedate;

    /**
     * @var int
     */
    private $nbrSprints;


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
     * @return Project
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
     * @return \DateTime
     */
    public function getDuedate(): \DateTime
    {
        return $this->duedate;
    }

    /**
     * @param \DateTime $duedate
     */
    public function setDuedate(\DateTime $duedate): void
    {
        $this->duedate = $duedate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Project
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Project
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set nbrSprints
     *
     * @param string $nbrSprints
     *
     * @return Project
     */
    public function setNbrSprints($nbrSprints)
    {
        $this->nbrSprints = $nbrSprints;

        return $this;
    }

    /**
     * Get nbrSprints
     *
     * @return string
     */
    public function getNbrSprints()
    {
        return $this->nbrSprints;
    }
}

