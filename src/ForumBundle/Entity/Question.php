<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ForumBundle\Concern\Taggable;
use Symfony\Component\Validator\Constraint as Assert;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\QuestionRepository")
 */
class Question
{
    use Taggable;
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
     * @ORM\Column(name="title", type="string", length=255)

     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     *
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->Categories;
    }

    /**
     * @param mixed $Categories
     */
    public function setCategories($Categories)
    {
        $this->Categories = $Categories;
    }

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Categories")
     * @ORM\JoinColumn(name="category_name",referencedColumnName="id")
     */
    private $Categories;

    /**
     * @var /datetime
     *
     * @ORM\Column(name="questionDate", type="datetime")
     */
    private $questionDate;

    /**
     * @return mixed
     */
    public function getQuestionDate()
    {
        return $this->questionDate;
    }

    /**
     * @param mixed $questionDate
     */
    public function setQuestionDate($questionDate)
    {
        $this->questionDate = $questionDate;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="likes", type="integer")
     */
    private $likes;
    /**
     * @var int
     *
     * @ORM\Column(name="views", type="integer")
     */
    private $views;

    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @param int $views
     */
    public function setViews(int $views): void
    {
        $this->views = $views;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="dislikes", type="integer")
     */
    private $dislikes;

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     */
    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    /**
     * @param int $dislikes
     */
    public function setDislikes(int $dislikes): void
    {
        $this->dislikes = $dislikes;
    }

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $User;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param mixed $User
     */
    public function setUser($User)
    {
        $this->User = $User;
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
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }



    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
     * Set title
     *
     * @param string $title
     *
     * @return Question
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }





    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
