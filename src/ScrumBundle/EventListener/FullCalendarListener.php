<?php


namespace ScrumBundle\EventListener;


use Doctrine\ORM\EntityManagerInterface;
use ScrumBundle\Entity\Projet;
use ScrumBundle\Repository\ProjetRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public function loadEvents(CalendarEvent $calendar){

        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        $projects = $this->em->getRepository(Projet::class)
            ->createQueryBuilder('projet')
            ->where('projet.created BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()->getResult();

        foreach($projects as $project) {

            // this create the events with your own entity (here booking entity) to populate calendar
            $Event = new Event(
                $project->getName(),
                $project->getCreated(),
                $project->getDuedate() // If the end date is null or not defined, it creates a all day event
            );

            /*
             * Optional calendar event settings
             *
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
             $Event->setBackgroundColor('#16cabd');
            // $bookingEvent->setCustomField('borderColor', $booking->getColor());

            $Event->setUrl(
                $this->router->generate('editProject', array(
                    'id' => $project->getId(),
                ))
            );

            // finally, add the booking to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($Event);
        }

    }





}