<?php

namespace TasksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TasksBundle\Entity\Media;
use TasksBundle\Entity\Tasks;
use TasksBundle\Form\TasksType;

class TasksController extends Controller
{

    public function editAction(Request $request, Tasks $task){
        $editForm=$this->createForm('TasksBundle\Form\TasksType',$task);
        $editForm->handleRequest($request);
        $media = new Media();

        if($editForm->isSubmitted() && $editForm->isValid())
        {
            $media->setPath($request->files->get('file'));
            $this->getDoctrine()->getManager()->flush();
            $this->addMedia($request, $media,$task);
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


    public function addMedia(Request $request,Media $media,Tasks $task){
       // dump($task);exit;
        //dump($media);exit;
        $file = $media->getPath();
        $fileName = md5(uniqid()).'.'.$file->getClientOriginalExtension();
        $file->move($this->getParameter('media_directory'), $fileName);
        $media->setPath($fileName);
        $media->setTasks($task);
        //
        $media->setName($file);
        $media->setType($file->getClientOriginalExtension());
        $em= $this->getDoctrine()->getManager();
        $em->persist($media);
        $em->flush();
    }

    public function showTasksAction(Request $request){

        $em= $this->getDoctrine()->getManager();

        $Tasks =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'To do'],['priority' => 'ASC']);
        $Tasks1 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Doing'],['priority' => 'ASC']);
        $Tasks2 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Done'],['priority' => 'ASC']);
        $Tasks3 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Block'],['priority' => 'ASC']);

        $task=new Tasks();
        $media = new Media();
        $form=$this->createForm('TasksBundle\Form\TasksType',$task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $media->setPath($request->files->get('file'));
            $em = $this->getDoctrine()->getManager();
            $task->setEtat(0);
            $task->setCreated(new \DateTime('now'));
            $task->setStatus("To do");
            $task->setUpdated(new \DateTime('now'));
            $em->persist($task);
            $em->flush($task);
           $this->addMedia($request, $media,$task);
            //dump($request);exit;
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
