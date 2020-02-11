<?php

namespace TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TeamBundle\Entity\role;
use TeamBundle\Form\roleType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Team/Default/index.html.twig');
    }

    public function affRoleAction()
    {
        $role=$this->getDoctrine()->getRepository('TeamBundle:Role')->findAll();
        return $this->render('@Team/Default/createRole.html.twig',
            array('p'=>$role));
    }

    public function ajoutRoleAction(Request $request)
    {
        $r= new role();
        $Form=$this->createForm(roleType::class,$r);
        $Form->handleRequest($request);

        if ($Form->isSubmitted() && $Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($r);
            $em->flush();
            $this->addFlash('info', 'Created Successfully !');
            return $this->redirectToRoute('team_homepage');
        }

        return $this->render('@Team/Default/createRole.html.twig',array(
            'f'=>$Form->createView()));
    }
  
}
