<?php

namespace TeamBundle\Controller;

use MainBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use TeamBundle\Entity\team_user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use TeamBundle\Entity\team;


class DefaultController extends Controller
{
    public function affecterAction(Request $request, $id){

        $team= $this->getDoctrine()->getRepository('TeamBundle:team')->find($id);
        $users= $this->getDoctrine()->getRepository('MainBundle:User')->findAll();
        $user=new User();
        $Form=$this->createFormBuilder($user)
            ->add('Email',EmailType::class)
            ->add('Envoyer',SubmitType::class,
                ['attr'=>['formvalidate'=>'formvalidate']])
            ->getForm();
        $Form->handleRequest($request);
        if($Form->isSubmitted()) {
            foreach ($users as $u) {
                if ($user->getEmail() == $u->getEmail()) {
                    return $this->render('@Team/team/existedeja.html.twig', array("id" => $id, "users" => $users));

                } else {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Affectation au team sur la plateforme Scrumify')
                        ->setFrom('iheb.rekik@esprit.tn')
                        ->setTo($user->getEmail())
                        ->setBody(
                            $this->renderView('@MyAppMail/Mail/mail1.html.twig',
                                array('team' => $team->getName(), 'text/html')));
                    $this->get('mailer')->send($message);
                }
            }
        }

        return $this->render('@Team/Default/affMembre.html.twig',array("id" => $id,"users"=>$users,'f'=>$Form->createView()));

    }


    public function affecterUserAction($team_id, $user_id){


        $users= $this->getDoctrine()->getRepository('MainBundle:User')->findAll();
        $user= $this->getDoctrine()->getRepository('MainBundle:User')->find($user_id);
        $team= $this->getDoctrine()->getRepository('TeamBundle:team')->find($team_id);
        $con3 = $this->getDoctrine()->getRepository('TeamBundle:team_user')->findBy(array('teamId' => $team_id));

       if ( $con3 != null) {
           foreach ($con3 as $con) {
               if ($con->getUserId() != $user_id) {
                   if ($con->getUserId()->getEmail() == $user->getEmail()) {
                       return $this->render('@Team/team/ajout1.html.twig', array("id" => $team_id, "users" => $users));
                   } else {
                       //envoyer mail notif
                       $message = \Swift_Message::newInstance()
                           ->setSubject('Affectation au team sur la plateforme Scrumify')
                           ->setFrom('iheb.rekik@esprit.tn')
                           ->setTo($user->getEmail())
                           ->setBody(
                               $this->renderView('@MyAppMail/Mail/mail.html.twig',
                                   array('team' => $team->getName(), 'text/html')));
                       $this->get('mailer')->send($message);

                       // affectation le user dans l'equipe
                       $aff = new team_user();
                       $aff->setTeamId($team);
                       $aff->setUserId($user);
                       $aff->setRole(1);
                       $em = $this->getDoctrine()->getManager();
                       $em->persist($aff);
                       $em->flush();
                   }


               } else {
                   return $this->render('@Team/team/ajout1.html.twig', array("id" => $team_id, "users" => $users));

               }

           }
       }
       else {
           //envoyer mail notif
           $message = \Swift_Message::newInstance()
               ->setSubject('Affectation au team sur la plateforme Scrumify')
               ->setFrom('iheb.rekik@esprit.tn')
               ->setTo($user->getEmail())
               ->setBody(
                   $this->renderView('@MyAppMail/Mail/mail.html.twig',
                       array('team' => $team->getName(), 'text/html')));
           $this->get('mailer')->send($message);

           // affectation le user dans l'equipe
           $aff = new team_user();
           $aff->setTeamId($team);
           $aff->setUserId($user);
           $aff->setRole(1);
           $em = $this->getDoctrine()->getManager();
           $em->persist($aff);
           $em->flush();
       }




        return $this->render('@Team/team/ajoutTeam.html.twig',array("id" => $team_id,"users"=>$users));

    }

}
