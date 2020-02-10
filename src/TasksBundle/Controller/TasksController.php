<?php

namespace TasksBundle\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TasksBundle\Entity\Tasks;
use TasksBundle\Form\TasksType;

class TasksController extends Controller
{
    public function addTasksAction( Request $request)
    {
                
    }

    public function showTasksAction(){


        $em= $this->getDoctrine()->getManager();
        $Tasks =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'To do'],['priority' => 'ASC']);
        $Tasks1 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Doing'],['priority' => 'ASC']);
        $Tasks2 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Done'],['priority' => 'ASC']);
        $Tasks3 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Block'],['priority' => 'ASC']);

        return $this->render('@Tasks/Tasks/home.html.twig',array(
            'TaskTodo'=> $Tasks,'TaskDoing'=> $Tasks1,'TaskDone'=> $Tasks2,'TaskBlock'=> $Tasks3));
    }


    public function archiveTasksAction(){




    }


}
