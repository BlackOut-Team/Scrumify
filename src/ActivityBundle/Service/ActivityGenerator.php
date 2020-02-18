<?php
namespace ActivityBundle\Service;
use ActivityBundle\Entity\Activity;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

class ActivityGenerator
{
    private $em;
    private $logger;

    public function __construct(LoggerInterface $logger,EntityManagerInterface $em)
    {

        $this->em = $em;
        $this->logger = $logger;
    }
    public function AjouterActivity($description, $user){
        $activity=new Activity();
        $activity->setAction($description);
        $activity->setUser($user);
        $activity->setViewed(0);
        $this->em->persist($activity);
        $this->em->flush();
    }
}