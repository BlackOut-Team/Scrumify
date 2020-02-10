<?php

namespace TasksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TasksBundle\Entity\Tasks;
use TasksBundle\Form\TasksType;

class TasksController extends Controller
{


    public function showTasksAction(Request $request){

        $em= $this->getDoctrine()->getManager();
        $Tasks =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'To do'],['priority' => 'ASC']);
        $Tasks1 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Doing'],['priority' => 'ASC']);
        $Tasks2 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Done'],['priority' => 'ASC']);
        $Tasks3 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Block'],['priority' => 'ASC']);

        $task=new Tasks();
        $form=$this->createForm('TasksBundle\Form\TasksType',$task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $task->setEtat(0);
            $task->setCreated(new \DateTime('now'));
            $task->setStatus("To do");
            $task->setUpdated(new \DateTime('now'));
            $em->persist($task);
            $em->flush($task);
            return $this->render('@Tasks/Tasks/home.html.twig',array(
                'task'=>$task,
                'form'=>$form->CreateView(),
                'TaskTodo'=> $Tasks,'TaskDoing'=> $Tasks1,'TaskDone'=> $Tasks2,'TaskBlock'=> $Tasks3
            )) ;
        }

        return $this->render('@Tasks/Tasks/home.html.twig',array(
            'form'=>$form->CreateView(),
            'TaskTodo'=> $Tasks,'TaskDoing'=> $Tasks1,'TaskDone'=> $Tasks2,'TaskBlock'=> $Tasks3));
    }


    public function archiveTasksAction(){


    }


}
