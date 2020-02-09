<?php

namespace TasksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TasksController extends Controller
{
    public function addTasksAction()
    {
        return $this->render('TasksBundle:Tasks:add_tasks.html.twig', array(
            // ...
        ));
    }

}
