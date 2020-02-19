<?php

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Activity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ActivityController extends Controller
{


    public function AfficherAction()
    {
        $Activities=$this->getDoctrine()
            ->getRepository(Activity::class)
            ->findAll();
        return $this->render('@Activity/Default/index.html.twig',
            array('activities'=>$Activities));
    }
    function SupprimerAction($id){
        $em=$this->getDoctrine()->getManager();
        $Activity=$em->getRepository(Activity::class)
            ->find($id);
        $em->remove($Activity);
        $em->flush();
        return $this->redirectToRoute('activity_homepage');

    }

}
