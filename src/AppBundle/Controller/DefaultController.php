<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('@App/index.html.twig');
    }
    public function homeAction()
    {
        return $this->render('@App/home.html.twig');
    }
}
