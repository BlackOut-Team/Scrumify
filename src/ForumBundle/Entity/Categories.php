<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categories
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\CategoriesRepository")
 */
class Categories
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     * @Assert\Length(
     *     min = 5,
     *     max = 50
     *     )
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string")
     */
    private $color;

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color)
    {
        $this->color = $color;
    }
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     *
     * @return string
     */
    public function getCname()
    {
        return $this->cname;
    }

    /**
     * @param string $cname
     */
    public function setCname(string $cname)
    {
        $this->cname = $cname;
    }

    /**
     * @var string
     * @ORM\Column(name="cname", type="string", length=255)
     *
     * @Assert\Length(
     *     min = 3,
     *     max = 50
     *     )
     */
    private $cname;
}
