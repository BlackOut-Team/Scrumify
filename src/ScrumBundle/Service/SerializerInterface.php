<?php

namespace ScrumBundle\Service;

use Toiba\FullCalendarBundle\Entity\Event;

interface SerializerInterface
{
    /**
     * @param Event[] $events
     *
     * @return string json
     */
    public function serialize(array $events);
}
