<?php

namespace SprintBundle\Controller;

use ScrumBundle\Entity\Projet;
use SprintBundle\Entity\Sprint;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Sprint/Default/index.html.twig');
    }
    public function  AddSAction(Request $request, Projet $projet)
    {
        $sprint=$this->getDoctrine()->getRepository(Sprint::class)->findBy(array('project'=>$projet->getId()));
        $s= new Sprint();
        $f=$this->createForm('SprintBundle\Form\SprintType',$s);
        $f->handleRequest($request);
        if ($f->isSubmitted() && $f->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $s->setProject($projet);
            $s->setEtat(1);
            $s->setCreated(new \DateTime('now'));
            $em->persist($s);

            $em->flush($s);

            return $this->redirectToRoute('addProject');

        }
        return $this->render('@Sprint/Default/index.html.twig',array(
            'f'=>$f->createView(),
            'sprint'=>$sprint ,
            'project'=>$projet,


        ));

    }

    public function archiverSAction(Request $request, Sprint $sprint){

        $em= $this->getDoctrine()->getManager();
        $sprint->setEtat(0);
        $em->persist($sprint);
        $em->flush($sprint);
        return $this->redirectToRoute('addSprint');

    }
    public function editSAction(Request $request, Sprint $sprint){
        $editForm=$this->createForm('SprintBundle\Form\SprintType',$sprint);
        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('Sprint_homepage');
        }
        return $this->render('@Sprint/Default/editS.html.twig', array(
            'edit_form' => $editForm->createView()
        ));
    }

}
