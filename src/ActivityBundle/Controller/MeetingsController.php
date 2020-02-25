<?php

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Activity;
use ActivityBundle\Entity\Meetings;
use ActivityBundle\Form\MeetingsType;
use Doctrine\ORM\EntityRepository;
use ScrumBundle\Entity\Projet;
use SprintBundle\Entity\Sprint;
use TeamBundle\Entity\team;
use TeamBundle\Entity\team_user;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Twilio\Rest\Client;

use Mgilet\NotificationBundle\Entity\Notification;
use Mgilet\NotificationBundle\NotifiableInterface;
class MeetingsController extends Controller
{

    function AfficheMettingAction($id,Request $request){

        $em = $this->getDoctrine()->getManager();

        //select project
        $project=$this->getDoctrine()
            ->getRepository(Projet::class)
            ->find($id);

        //select sprints mil base de donnee(array)
        $sprints = $this->getDoctrine()
            ->getRepository(Sprint::class)
            ->findBy(['project' => $project]);

        //select team
        $team = $this->getDoctrine()
            ->getRepository(team::class)
            ->find($project->getTeam());

        //select team members
        $teamMembers = $this->getDoctrine()
            ->getRepository(team_user::class)
            ->findBy(['teamId' => $team->getId()]);

        //display meeting
        $meetingadd = new Meetings();
        $meeting=$this->getDoctrine()
            ->getRepository(Meetings::class)
            ->findAll();

        //display activities
        $Activities=$this->getDoctrine()
            ->getRepository(Activity::class)
            ->findBy(['viewed' => 1]);

        //display new activities
        $NewActivities=$this->getDoctrine()
            ->getRepository(Activity::class)
            ->findBy(['viewed'=>0]);

        //create form
        $ajouterFrorm = $this->createForm(MeetingsType::class, $meetingadd);
        $ajouterFrorm->handleRequest($request);

        if ($ajouterFrorm->isSubmitted() && $ajouterFrorm->isValid()) {

            //create meeting
            $em->persist($meetingadd);
            $em->flush();


            //appel lel service mta bundle extern -> createNotification
            $notif =$this->get('mgilet.notification')->createNotification('Meeting !', "you have a meeting (". $meetingadd->getName() .") in " . $meetingadd->getPlace() ." at ". $meetingadd->getMeetingDate()->format('Y-m-d H:i'), '');
            foreach ( $teamMembers as $teamMember){
                $this->get('mgilet.notification')->addNotification(array($teamMember->getUserId()), $notif, true);
            }
            //send sms when adding meeting (extern bundle)
            //$sid = "ACabcbc80d4384e812cad9003a0e0572df"; // Your Account SID from www.twilio.com/console
            //$token = "88420746fc00b5b421774e629777891a"; // Your Auth Token from www.twilio.com/console

            //$client = new Client($sid, $token);
            //$client->messages->create(
                //'+21655515552', // Text this number
                //array(
                    //'from' => '+12563636360', // From a valid Twilio number
                    //'body' => "you have a meeting (". $meetingadd->getName() .") in " . $meetingadd->getPlace() ." at ". $meetingadd->getMeetingDate()->format('Y-m-d H:i')
                //)
            return $this->redirectToRoute('affichermeeting',['id'=>$id]);

        }
        return $this->render('@Activity/Default/activity.html.twig',
            array('activities'=>$Activities,'m'=>$meeting, "f"=>$ajouterFrorm->createView(), 'newActivities'=>$NewActivities, 'sprints'=> $sprints, 'id' => $id, 'team' =>$teamMembers));
    }




    function SupprimerAction($id,$project_id){
        $em=$this->getDoctrine()->getManager();
        $meeting=$em->getRepository(Meetings::class)
            ->find($id);
        $em->remove($meeting);
        $em->flush();
        return $this->redirectToRoute('affichermeeting',['id' =>$project_id ]);

    }
    function modifierAction($id,$project_id , Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $meeting = $em->getRepository(Meetings::class)
            ->find($id);
        $Form = $this->createForm(MeetingsType::class, $meeting);
        $Form->handleRequest($request);


        if ($Form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affichermeeting',['id' =>$project_id ]);

        }
        return $this->render('@Activity/Default/modifierMeeting.html.twig',
            array('f' => $Form->createView()));

    }

}
