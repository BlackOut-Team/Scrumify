<?php

namespace SprintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Sprint/Default/index.html.twig');
    }
    public function indexPAction()
    {
        return $this->render('@Sprint/Default/index.html.twig');
    }
    public function createPAction()
    {
        return $this->render('@Sprint/Default/createProject.html.twig');
    }

}
