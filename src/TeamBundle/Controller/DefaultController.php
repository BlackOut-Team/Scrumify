<?php

namespace TeamBundle\Controller;

use MainBundle\Entity\User;
use TeamBundle\Entity\team_user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use TeamBundle\Entity\team;


class DefaultController extends Controller
{
    public function affecterAction($id,Request $request){

       $users= $this->getDoctrine()->getRepository('MainBundle:User')->findAll();


        return $this->render('@Team/Default/affMembre.html.twig',array("id" => $id,"users"=>$users));

    }


    public function affecterUserAction($team_id, $user_id){

        $users= $this->getDoctrine()->getRepository('MainBundle:User')->findAll();
        $user= $this->getDoctrine()->getRepository('MainBundle:User')->find($user_id);
        $team= $this->getDoctrine()->getRepository('TeamBundle:team')->find($team_id);



        $aff= new team_user();


        $aff->setTeamId($team);
        $aff->setUserId($user);

            


        $em = $this->getDoctrine()->getManager();
        $em->persist($aff);

        $em->flush();


        return $this->render('@Team/Default/affMembre.html.twig',array("id" => $team_id,"users"=>$users));

    }
}
