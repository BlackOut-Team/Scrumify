<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexPAction()
    {
        return $this->render('@Project/Default/index.html.twig');
    }
    public function createPAction()
    {
        return $this->render('@Project/Default/createProject.html.twig');
    }
}
