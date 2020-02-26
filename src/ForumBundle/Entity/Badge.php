<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Badge
 *
 * @ORM\Table(name="badge")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\BadgeRepository")
 */
class Badge
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * Permet de sauvegarder l'action à effectuer pour débloquer le badge (par exemple "comment")
     *
     * @var string
     *
     * @ORM\Column(name="action_name", type="string", length=255)
     */
    private $actionName;

    /**
     * Permet de sauvegarder la quantité d'action à effectuer pour débloquer le badge
     *
     * @var int
     *
     * @ORM\Column(name="action_count", type="integer")
     */
    private $actionCount;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;
    }

    /**
     * @return int
     */
    public function getActionCount()
    {
        return $this->actionCount;
    }

    /**
     * @param int $actionCount
     */
    public function setActionCount($actionCount)
    {
        $this->actionCount = $actionCount;
    }

    /**
     * @return array
     */
    public function getUnlocks()
    {
        return $this->unlocks;
    }

    /**
     * @param array $unlocks
     */
    public function setUnlocks($unlocks)
    {
        $this->unlocks = $unlocks;
    }

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\BadgeUnlock", mappedBy="badge")
     */
    private $unlocks;

    /**
     * ... GETTER / SETTER
     **/
}