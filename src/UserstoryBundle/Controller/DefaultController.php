<?php

namespace UserstoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserstoryBundle:Default:index.html.twig');
    }
}
