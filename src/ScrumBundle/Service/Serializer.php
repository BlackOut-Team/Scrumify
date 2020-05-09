<?php

namespace ScrumBundle\Service;

use Toiba\FullCalendarBundle\Entity\Event;

class Serializer implements SerializerInterface
{
    /**
     * @param Event[] $events
     *
     * @return string json
     */
    public function serialize(array $events)
    {
        $result = [];

        foreach ($events as $event) {
            $result[] = $event->toArray();
        }

        return json_encode($result);
    }
}
