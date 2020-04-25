<?php

namespace SprintBundle\Controller;

use ScrumBundle\Entity\Projet;
use SprintBundle\Entity\Sprint;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TeamBundle\Entity\team_user;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Sprint/Default/index.html.twig');
    }
    public function  AddSAction(Request $request, Projet $projet)
    {
       // $team=$this->getDoctrine()->getRepository(Projet::class)->findBy(['etat'=>1,'id'=>$projet->getTeam()]);
      //  $members=$this->getDoctrine()->getRepository(team_user::class)->find($team);
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

            return $this->redirectToRoute('Sprint_homepage',array('id' => $projet->getId()));
        }
        return $this->render('@Sprint/Default/addS.html.twig',array(
            'f'=>$f->createView(),
            'project'=>$projet,
          //  'members'=> $members ,


        ));

    }

    public function archiverSAction(Request $request, Projet $projet,Sprint $sprint){

        $em= $this->getDoctrine()->getManager();
        $sprint->setEtat(0);
        $em->persist($sprint);
        $em->flush();
        return $this->redirectToRoute('Sprint_homepage',array('id' => $projet->getId()));

    }
    public function editSAction(Request $request, Projet $projet  , Sprint $sprint){

        $editForm=$this->createForm('SprintBundle\Form\SprintType',$sprint);
        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid())
        {
            $sprint->setProject($projet);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('Sprint_homepage',array('id' => $projet->getId()));
        }
        return $this->render('@Sprint/Default/editS.html.twig', array(
            'edit_form' => $editForm->createView(),
            'project' => $projet,
        ));
    }

    public function  showSprintsAction(Projet $projet){

        $sprint=$this->getDoctrine()->getRepository(Sprint::class)->findBy(array('project'=>$projet->getId()));


        return $this->render('@Sprint/Default/index.html.twig',array(
            'sprint'=>$sprint ,
            'project'=>$projet,


        ));

    }

}
