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

            return $this->redirect($request->getUri());
        }
        return $this->render('@Sprint/Default/index.html.twig',array(
            'f'=>$f->createView(),
            'sprint'=>$sprint ,
            'project'=>$projet,


        ));

    }

    public function archiverSAction(Request $request, Projet $projet,Sprint $sprint){

        $em= $this->getDoctrine()->getManager();
        $sprint->setEtat(0);
        $em->persist($sprint);
        $em->flush();
        return $this->redirectToRoute('addProject');

    }
    public function editSAction(Request $request, Projet $projet  , Sprint $sprint){

        $editForm=$this->createForm('SprintBundle\Form\SprintType',$sprint);
        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid())
        {
            $sprint->setProject($projet);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('addProject');
        }
        return $this->render('@Sprint/Default/editS.html.twig', array(
            'edit_form' => $editForm->createView(),
            'project' => $projet,
        ));
    }

}
