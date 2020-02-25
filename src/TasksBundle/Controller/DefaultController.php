<?php

namespace TasksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TasksBundle\Entity\taskuser;

class DefaultController extends Controller
{

    public function homeAction()
    {
        return $this->render('@Tasks/Tasks/home.html.twig');
    }


    public function affUserTaskAction($task_id, $user_id){

        $users= $this->getDoctrine()->getRepository('MainBundle:User')->findAll();
        $user= $this->getDoctrine()->getRepository('MainBundle:User')->find($user_id);
        $task= $this->getDoctrine()->getRepository('TasksBundle:Tasks')->find($task_id);



        $aff= new taskuser();


        $aff->setTaskId($task);
        $aff->setUserId($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($aff);

        $em->flush();
        return $this->render('@Tasks/Tasks/home.html.twig',array("id" => $task_id,"users"=>$users));

    }
}
