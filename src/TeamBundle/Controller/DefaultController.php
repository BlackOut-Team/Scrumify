<?php

namespace TeamBundle\Controller;

use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use FOS\UserBundle\Event\FormEvent;
use MainBundle\Entity\User;
use Swift_Message;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Form;
use TeamBundle\Entity\team_user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class DefaultController extends Controller
{
    public function affecterAction(Request $request, $id){

        $team= $this->getDoctrine()->getRepository('TeamBundle:team')->find($id);
        $users= $this->getDoctrine()->getRepository('MainBundle:User')->findAll();
        $user=new User();
        $Form=$this->createFormBuilder($user)
            ->add('Email',EmailType::class,
                ['attr'=>['placeholder'=>'Invite user to scrumify by Email']])
            ->add('Envoyer',SubmitType::class,
                ['attr'=>['formvalidate'=>'formvalidate']])
            ->getForm();

                $Form->handleRequest($request);

                if ($Form->isSubmitted()) {


                        foreach ($users as $u) {
                            if ($user->getEmail() == $u->getEmail()) {
                                return $this->render('@Team/team/existedeja.html.twig', array("id" => $id, "users" => $users));

                            } else {
                                $message = Swift_Message::newInstance()
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


   /* public function affecterUser($team_id, $user_id,$role){


        $users= $this->getDoctrine()->getRepository('MainBundle:User')->findAll();
        $user= $this->getDoctrine()->getRepository('MainBundle:User')->find($user_id);
        $team= $this->getDoctrine()->getRepository('TeamBundle:team')->find($team_id);

        $con3 = $this->getDoctrine()->getRepository('TeamBundle:team_user')->findBy(array('teamId' => $team_id,'userId'=>$user_id));

        if ( $con3 != null) {

            //return $this->render('@Team/team/ajout1.html.twig', array("id" => $team_id, "users" => $users));
            return false;
        }
        else {
            if ($role == 3) {
                $con2 = $this->getDoctrine()->getRepository('TeamBundle:team_user')->findBy(array('teamId' => $team_id, 'userId' => $user_id, 'role' => 3));
                if ($con2 == null) {
                    //envoyer mail notif
                    $message = Swift_Message::newInstance()
                        ->setSubject('Affectation au team sur la plateforme Scrumify : Product owner')
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
                    $aff->setRole($role);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($aff);
                    $em->flush();

                   // return $this->render('@Team/team/ajoutTeam.html.twig', array("id" => $team_id, "users" => $users));
                    //return $this->render('@Team/team/success.html.twig');
                    return true;

                } else {
                    //return $this->render('@Team/team/ajout1.html.twig', array("id" => $team_id, "users" => $users));
                        return false;
                }
            } else if ($role == 2) {
                $con1 = $this->getDoctrine()->getRepository('TeamBundle:team_user')->findBy(array('teamId' => $team_id, 'userId' => $user_id, 'role' => 2));


                //envoyer mail notif
                $message = Swift_Message::newInstance()
                    ->setSubject('Affectation au team sur la plateforme Scrumify : developer')
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
                $aff->setRole($role);
                $em = $this->getDoctrine()->getManager();
                $em->persist($aff);
                $em->flush();

              //  return $this->render('@Team/team/ajoutTeam.html.twig', array("id" => $team_id, "users" => $users));
               // return $this->render('@Team/team/success.html.twig');
           return true;
            }
            else
                {
                   // return $this->render('@Team/team/error.html.twig');
         return false;
                }

        }




    }*/

    public function affecterUserAction(Request $request,$team_id, $user_id){


        $formData = $request->query->get('role_select');
        $role =$formData;
        //var_dump($role);
        $users= $this->getDoctrine()->getRepository('MainBundle:User')->findAll();
        $user= $this->getDoctrine()->getRepository('MainBundle:User')->find($user_id);
        $team= $this->getDoctrine()->getRepository('TeamBundle:team')->find($team_id);

        $con3 = $this->getDoctrine()->getRepository('TeamBundle:team_user')->findBy(array('teamId' => $team_id,'userId'=>$user_id));

        if ( $con3 != null) {

            return $this->render('@Team/team/ajout1.html.twig', array("id" => $team_id, "users" => $users));
            //return false;
        }
        else {
            if ($role == 3) {
                $con2 = $this->getDoctrine()->getRepository('TeamBundle:team_user')->findBy(array('teamId' => $team_id, 'userId' => $user_id, 'role' => 3));
                if ($con2 == null) {
                    //envoyer mail notif
                    $message = Swift_Message::newInstance()
                        ->setSubject('Affectation au team sur la plateforme Scrumify : Product owner')
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
                    $aff->setRole($role);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($aff);
                    $em->flush();

                    // return $this->render('@Team/team/ajoutTeam.html.twig', array("id" => $team_id, "users" => $users));
                    return $this->render('@Team/team/success.html.twig');
                    //return true;

                } else {
                    return $this->render('@Team/team/ajout1.html.twig', array("id" => $team_id, "users" => $users));
                    //return false;
                }
            } else if ($role == 2) {
                $con1 = $this->getDoctrine()->getRepository('TeamBundle:team_user')->findBy(array('teamId' => $team_id, 'userId' => $user_id, 'role' => 2));


                //envoyer mail notif
                $message = Swift_Message::newInstance()
                    ->setSubject('Affectation au team sur la plateforme Scrumify : developer')
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
                $aff->setRole($role);
                $em = $this->getDoctrine()->getManager();
                $em->persist($aff);
                $em->flush();

                //  return $this->render('@Team/team/ajoutTeam.html.twig', array("id" => $team_id, "users" => $users));
                return $this->render('@Team/team/success.html.twig');
                //return true;
            }
            else
            {
                return $this->render('@Team/team/error.html.twig');
                //return false;
            }

        }





    }
}
