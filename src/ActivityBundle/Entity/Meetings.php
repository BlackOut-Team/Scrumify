<?php

namespace ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Meetings
 *
 * @ORM\Table(name="meetings")
 * @ORM\Entity(repositoryClass="ActivityBundle\Repository\MeetingsRepository")
 */
class Meetings
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
     * @var /datetime
     *
     * @ORM\Column(name="meetingDate", type="datetime")
     */
    private $meetingDate;

    /**
     * @return mixed
     */
    public function getMeetingDate()
    {
        return $this->meetingDate;
    }

    /**
     * @param mixed $meetingDate
     */
    public function setMeetingDate($meetingDate): void
    {
        $this->meetingDate = $meetingDate;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


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
     * Set name.
     *
     * @param string $name
     *
     * @return Meetings
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set place.
     *
     * @param string $place
     *
     * @return Meetings
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place.
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Meetings
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
