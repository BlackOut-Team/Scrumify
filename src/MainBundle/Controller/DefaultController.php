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
    public function registerAction()
    {
        return $this->render('@Main/Default/register.html.twig');
    }
}
