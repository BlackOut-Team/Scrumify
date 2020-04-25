<?php

namespace TasksBundle\Controller;

use MainBundle\Entity\User;
use MyAppMailBundle\Entity\Mail;
use MyAppMailBundle\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TasksBundle\Entity\Media;
use TasksBundle\Entity\Tasks;
use TasksBundle\Form\TasksType;
use ActivityBundle\Service\ActivityGenerator;
use Headsnet\Sms\SmsSendingInterface;
use UserstoryBundle\Entity\userstory;


class TasksController extends Controller
{

    public function changeStatusAction( Tasks $task,string $statut){
        $em= $this->getDoctrine()->getManager();
        $task->setStatus($statut);
        $em->persist($task);
        $em->flush();
        return $this->redirectToRoute('show_tasks',array('id' => $task->getUserstory()->getId()));

    }



    public function editAction(Request $request, Tasks $task){
        $em= $this->getDoctrine()->getManager();
        $m =$em->getRepository('TasksBundle:Media')->findby(array('tasks'=>$task->getId()));
        $editForm=$this->createForm('TasksBundle\Form\TasksType',$task);
        $editForm->handleRequest($request);
        $media = new Media();

        if($editForm->isSubmitted() && $editForm->isValid())
        {
            $media->setPath($request->files->get('file'));
            $this->getDoctrine()->getManager()->flush();
            $this->addMedia($request, $media,$task);
            $task->setUpdated(new \DateTime('now'));
            return $this->redirectToRoute('show_tasks',array('id' => $task->getUserstory()->getId()));
        }
        return $this->render('@Tasks/Tasks/edit.html.twig', array(
            'edit_form' => $editForm->createView() ,'m'=>$m
        ));
    }

    public function archiverAction(Request $request, Tasks $task){

        $em= $this->getDoctrine()->getManager();
        $task->setEtat(1);
        $em->persist($task);
        $em->flush();
        return $this->redirectToRoute('show_tasks',array('id' => $task->getUserstory()->getId()));


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
        $fileName = $file->getClientOriginalName();
        $file->move($this->getParameter('media_directory'), $fileName);
        $media->setPath($file);
        $media->setTasks($task);

        $media->setName($fileName);
        $media->setType($file->getClientOriginalExtension());
        $em= $this->getDoctrine()->getManager();
        $em->persist($media);
        $em->flush();
    }

    public function showTasksAction(Request $request, userstory $userstory){

        $em= $this->getDoctrine()->getManager();

        $Tasks =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Todo','Userstory'=>$userstory],['priority' => 'ASC']);
        $Tasks1 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Doing','Userstory'=>$userstory],['priority' => 'ASC']);
        $Tasks2 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Done','Userstory'=>$userstory],['priority' => 'ASC']);
        $Tasks3 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Block','Userstory'=>$userstory],['priority' => 'ASC']);
        $users =$em->getRepository('MainBundle:User')->findall();

        $task=new Tasks();
        $media = new Media();
        $form=$this->createForm('TasksBundle\Form\TasksType',$task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {


            //$activityGenerator = $this->get(ActivityGenerator::class);
            //$activity = $activityGenerator->AjouterActivity('a ajouter une tache', 'hidaya');
            //$this->addFlash('success', $activity);
            $usernames = $request->request->get('users');
            $media->setPath($request->files->get('file'));
            $usersToAffect =$em->getRepository('MainBundle:User')->findBy(['username'=>'']);
            foreach ($usernames as $username){
                $a =$em->getRepository('MainBundle:User')->findOneBy(['username'=>$username]);
                array_push($usersToAffect,$a);
            }

            $em = $this->getDoctrine()->getManager();
            $task->setEtat(0);
            $task->setCreated(new \DateTime('now'));
            $task->setStatus("Todo");
            $task->setUpdated(new \DateTime('now'));
            $task->setUserstory($userstory);
            $task->setUser($usersToAffect);
        foreach ($usersToAffect as $item) {
            $mail = new Mail();
            $form = $this->createForm(MailType::class, $mail);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Accusé de réception')
                    ->setFrom('iheb.rekik@esprit.tn')
                    ->setTo($item->getEmail())
                    ->setBody(
                        $this->renderView('@MyAppMail/Mail/mail.html.twig',
                            array('nom' => $mail->getNom(), 'prenom' => $mail->getPrenom())), 'text/html');
                $this->get('mailer')->send($message);
            }
        }


            $em->persist($task);
            $em->flush($task);
           $this->addMedia($request, $media,$task);
           // dump($request);exit;
            return $this->redirectToRoute('show_tasks',array('id' => $userstory->getId())) ;
        }

        return $this->render('@Tasks/Tasks/home.html.twig',array(
            'form'=>$form->CreateView(),
            'TaskTodo'=> $Tasks,'TaskDoing'=> $Tasks1,'TaskDone'=> $Tasks2,'TaskBlock'=> $Tasks3,'users'=>$users,'userstory'=>$userstory));

    }






}
