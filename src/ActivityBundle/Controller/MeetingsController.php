<?php

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Activity;
use ActivityBundle\Entity\Meetings;
use ActivityBundle\Form\MeetingsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Twilio\Rest\Client;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MeetingsController extends Controller
{

    function AfficheMettingAction(Request $request,ValidatorInterface $validator){
        //afficher meetings
        $meetingadd = new Meetings();
        $errors = $validator->validate($meetingadd);
        $meeting=$this->getDoctrine()
            ->getRepository(Meetings::class)
            ->findAll();

        //afficher activite
        $Activities=$this->getDoctrine()
            ->getRepository(Activity::class)
            ->findBy(['viewed' => 1]);

        //afficher new activite
        $NewActivities=$this->getDoctrine()
            ->getRepository(Activity::class)
            ->findBy(['viewed'=>0]);

        //form to add meeting
        $ajouterFrorm = $this->createForm(MeetingsType::class, $meetingadd);
        $ajouterFrorm->handleRequest($request);
        if ($ajouterFrorm->isSubmitted() && $ajouterFrorm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($meetingadd);
            $em->flush();

            //send sms when adding meeting (extern bundle)
            $sid = "ACabcbc80d4384e812cad9003a0e0572df"; // Your Account SID from www.twilio.com/console
            $token = "88420746fc00b5b421774e629777891a"; // Your Auth Token from www.twilio.com/console
            $client = new Client($sid, $token);
            $client->messages->create(
                '+21655515552', // Text this number
                array(
                    'from' => '+12563636360', // From a valid Twilio number
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
