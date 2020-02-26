<?php

namespace TasksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * taskuser
 *
 * @ORM\Table(name="taskuser")
 * @ORM\Entity(repositoryClass="TasksBundle\Repository\taskuserRepository")
 */
class taskuser
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
     * @var int
     * @ORM\ManyToOne(targetEntity="TasksBundle\Entity\Tasks")
     * @ORM\JoinColumn(name="task_id",referencedColumnName="id")
     */
    private $taskId;

    /**
     * @return int
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * @param int $taskId
     */
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;
    }

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $userId;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
