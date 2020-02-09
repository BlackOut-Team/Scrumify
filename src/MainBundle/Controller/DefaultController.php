<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('@Main/Default/index.html.twig');
    }
    /**
     * @Route("/register")
     */
    public function loginAction()
    {
        return $this->render('@Main/Security/login.html.twig');
    }
    public function registerAction()
    {
        return $this->render('@Main/Registration/register.html.twig');
    }
    /**
     * @Route("/home")
     */
    public function homeAction()
    {
        return $this->render('@Main/Default/home.html.twig');
    }

}
