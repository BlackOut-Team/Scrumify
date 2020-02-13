<?php

namespace TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="TeamBundle\Repository\roleRepository")
 */
class role
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
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * @var int
     *
     * @ORM\Column(name="ind", type="integer")
     */
    private $ind;


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
     * Set role.
     *
     * @param string $role
     *
     * @return role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set ind.
     *
     * @param int $ind
     *
     * @return role
     */
    public function setInd($ind)
    {
        $this->ind = $ind;

        return $this;
    }

    /**
     * Get ind.
     *
     * @return int
     */
    public function getInd()
    {
        return $this->ind;
    }
}
