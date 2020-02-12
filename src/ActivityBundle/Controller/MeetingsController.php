<?php

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Meetings;
use ActivityBundle\Form\MeetingsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MeetingsController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $meeting = new Meetings();
        $Form = $this->createForm(MeetingsType::class, $meeting);


        $Form->handleRequest($request);

        if ($Form->isSubmitted() && $Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($meeting);
            $em->flush();
            return $this->redirectToRoute('affichermeeting');

        }

        return $this->render('@Activity/Default/meetings.html.twig',
            array('f' => $Form->createView()));
    }
    function AfficheMettingAction(){
        $meeting=$this->getDoctrine()
            ->getRepository(Meetings::class)
            ->findAll();
        return $this->render('@Activity/Default/afficherMeeting.html.twig',
            array('m'=>$meeting));
    }
    function SupprimerAction($id){
        $em=$this->getDoctrine()->getManager();
        $meeting=$em->getRepository(Meetings::class)
            ->find($id);
        $em->remove($meeting);
        $em->flush();
        return $this->redirectToRoute('affichermeeting');

    }
    function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $meeting = $em->getRepository(Meetings::class)
            ->find($id);
        $Form = $this->createForm(MeetingsType::class, $meeting);
        $Form->handleRequest($request);


        if ($Form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affichermeeting');

        }
        return $this->render('@Activity/Default/modifierMeeting.html.twig',
            array('f' => $Form->createView()));

    }

}
