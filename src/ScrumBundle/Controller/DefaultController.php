<?php

namespace ScrumBundle\Controller;

use ScrumBundle\Entity\Projet;
use SprintBundle\Entity\Sprint;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function  AddPAction(Request $request)
    {
        $project=$this->getDoctrine()->getRepository(Projet::class)->findAll();
      //  $sprint=$this->getDoctrine()->getRepository(Sprint::class)->findBy(['project_id'=> $project-]);
        $p= new Projet();
        $f=$this->createForm('ScrumBundle\Form\ProjetType',$p);
        //dump($f,$request);exit;
        $f->handleRequest($request);
        $projet=new Projet();
        $Form=$this->createFormBuilder($projet)
            ->add('name')
            ->add('Recherche',SubmitType::class,
                ['attr'=>['formvalidate'=>'formvalidate']])
            ->getForm();
        $Form->handleRequest($request);
        if($Form->isSubmitted()){
            $projet=$this->getDoctrine()->getRepository(Projet::class)->findBy(array('name'=>$projet->getName()));
        }

        if ($f->isSubmitted() && $f->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $p->setCreated(new \DateTime('now'));
            $p->setEtat(1);

            $em->persist($p);
            $em->flush($p);

            return $this->redirectToRoute('addProject');

        }
        return $this->render('@Scrum/Default/createProject.html.twig',array(
            'f'=>$f->createView(),
            'project'=>$project ,
            'r'=>$Form->createView()

        ));

    }

    public function archiverPAction(Request $request, Projet $project){

        $em= $this->getDoctrine()->getManager();
        $project->setEtat(1);
        $em->persist($project);
        $em->flush();
        return $this->redirectToRoute('affiche_role');

    }
    public function editPAction(Request $request, Projet $project){
        $editForm=$this->createForm('ScrumBundle\Form\ProjetType',$project);
        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('addProject');
        }
        return $this->render('@Scrum/Default/editP.html.twig', array(
            'edit_form' => $editForm->createView()
        ));
    }

    public function  showPAction(Request $request)
    {
        $project=$this->getDoctrine()->getRepository(Projet::class)->findAll();


        return $this->render('@Scrum/Back/projects.html.twig',array(
            'pp'=>$project

        ));

    }
    public function desarchiverPAction(Request $request, Projet $pp){

        $em= $this->getDoctrine()->getManager();
        $pp->setEtat(1);
        $em->persist($pp);
        $em->flush();
        return $this->redirectToRoute('showProject');

    }
    function searchPAction(Request $request){


    }
   /* function SearchAction(Request $request){
        $projet=new Projet();
        $em=$this->getDoctrine()->getManager();
        $Form=$this->createForm(SearchType::class,$projet);
        $Form->handleRequest($request);
        if($Form->isSubmitted()){
            $club=$em->getRepository(Projet::class)
                ->findBy(array('nom'=>$projet->getName()));
        }
        else{
            $club=$em->getRepository(Projet::class)
                ->findAll();
        }
        //var_dump($club->ge);
        return $this->render('@Club/Club/createProject.html.twig',
            array('project'=>$projet,'r'=>$Form->createView()));
    }*/
}
