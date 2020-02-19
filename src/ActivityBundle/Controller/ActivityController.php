<?php

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Activity;
use ActivityBundle\Entity\Meetings;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ActivityController extends Controller
{


    public function AfficherAction()
    {
        $Activities=$this->getDoctrine()
            ->getRepository(Activity::class)
            ->findAll();

        $meeting=$this->getDoctrine()
            ->getRepository(Meetings::class)
            ->findAll();
        return $this->render('@Activity/Default/activity.html.twig',
            array('activities'=>$Activities,'m'=>$meeting));
    }
    function SupprimerAction($id){
        $em=$this->getDoctrine()->getManager();
        $Activity=$em->getRepository(Activity::class)
            ->find($id);
        $em->remove($Activity);
        $em->flush();
        return $this->redirectToRoute('affichermeeting');

    }
    public function ChangeActivityStateAction($id){
        $em = $this->getDoctrine()->getManager();
        $activity = $em->getRepository(Activity::class)
            ->find($id);
        $activity->setViewed(1);
        $em->flush();
        return $this->redirectToRoute('affichermeeting');
    }

}
