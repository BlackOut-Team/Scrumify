<?php

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Activity;
use ActivityBundle\Entity\Meetings;
use ActivityBundle\Form\MeetingsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Twilio\Rest\Client;

class MeetingsController extends Controller
{

    function AfficheMettingAction(Request $request){
        $meetingadd = new Meetings();
        $meeting=$this->getDoctrine()
            ->getRepository(Meetings::class)
            ->findAll();
        $Activities=$this->getDoctrine()
            ->getRepository(Activity::class)
            ->findBy(['viewed' => 1]);
        $NewActivities=$this->getDoctrine()
            ->getRepository(Activity::class)
            ->findBy(['viewed'=>0]);
        $ajouterFrorm = $this->createForm(MeetingsType::class, $meetingadd);
        $ajouterFrorm->handleRequest($request);

        if ($ajouterFrorm->isSubmitted() && $ajouterFrorm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($meetingadd);
            $em->flush();

            $sid = "ACfa0d7e8561f3c6a338c4ddee27aa9512"; // Your Account SID from www.twilio.com/console
            $token = "f83e84fb31bbc18e08745e5ee5239962"; // Your Auth Token from www.twilio.com/console

            $client = new Client($sid, $token);
            $client->messages->create(
                '+21650963557', // Text this number
                array(
                    'from' => '+19175125796', // From a valid Twilio number
                    'body' => "you have a meeting (". $meetingadd->getName() .") in " . $meetingadd->getPlace() ." at ". $meetingadd->getMeetingDate()->format('Y-m-d H:i')
                )
            );
            return $this->redirectToRoute('affichermeeting');

        }
        return $this->render('@Activity/Default/activity.html.twig',
            array('activities'=>$Activities,'m'=>$meeting, "f"=>$ajouterFrorm->createView(), 'newActivities'=>$NewActivities ));
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
