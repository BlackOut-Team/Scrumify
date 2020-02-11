<?php

namespace SprintBundle\Controller;

use ProjectBundle\Entity\Project;
use SprintBundle\Entity\Sprint;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Sprint/Default/index.html.twig');
    }
    public function  AddSAction(Request $request)
    {
        $sprint=$this->getDoctrine()->getRepository(Sprint::class)->findAll();
        $s= new Sprint();
        $f=$this->createForm('SprintBundle\Form\SprintType',$s);
        $f->handleRequest($request);
        if ($f->isSubmitted() && $f->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $s->setCreated(new \DateTime('now'));
            $em->persist($s);
            $em->flush($s);

            return $this->redirectToRoute('addSprint');

        }
        return $this->render('@Sprint/Default/index.html.twig',array(
            'f'=>$f->createView(),
            'sprint'=>$sprint

        ));

    }

    public function archiverSAction(Request $request, Project $project){

        $em= $this->getDoctrine()->getManager();
        $project->setstate(1);
        $em->persist($project);
        $em->flush();
        return $this->redirectToRoute('addSprint');

    }
}
