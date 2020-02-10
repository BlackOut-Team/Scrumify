<?php

namespace TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Team/Default/index.html.twig');
    }

    public function AffRoleAction()
    {
        $role=$this->getDoctrine()->getRepository('TeamBundle:Role')->findAll();
        return $this->render('@Team/Default/createRole.html.twig',
            array('p'=>$role));
    }


  
}
