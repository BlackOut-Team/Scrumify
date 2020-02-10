<?php

namespace TasksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function homeAction()
    {
        return $this->render('@Tasks/Tasks/home.html.twig');
    }
}
