<?php

namespace TasksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TasksBundle\Entity\Tasks;
use TasksBundle\Form\TasksType;

class TasksController extends Controller
{

    public function editAction(Request $request, Tasks $task){
        $editForm=$this->createForm('TasksBundle\Form\TasksType',$task);
        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('show_tasks');
        }
        return $this->render('@Tasks/Tasks/edit.html.twig', array(
            'edit_form' => $editForm->createView()
        ));
    }

    public function archiverAction(Request $request, Tasks $task){

        $em= $this->getDoctrine()->getManager();
        $task->setEtat(1);
        $em->persist($task);
        $em->flush();
            return $this->redirectToRoute('show_tasks');

    }
    public function desarchiverAction(Request $request, Tasks $pp){

        $em= $this->getDoctrine()->getManager();
        $pp->setEtat(0);
        $em->persist($pp);
        $em->flush();
        return $this->redirectToRoute('show_tasks_back');
    }

    public function showTasksBAction (Request $request){

        $taskB=$this->getDoctrine()->getRepository(Tasks::class)->findAll();


        return $this->render('@Tasks/Tasks/homeBack.html.twig',array(
            'pp'=>$taskB

        ));
    }
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





}
