<?php

namespace ProjectBundle\Controller;

use ProjectBundle\Entity\Project;
use ProjectBundle\Form\ProjectType;
use ProjectBundle\ProjectBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexPAction()
    {
        return $this->render('@Project/Default/createProject.html.twig');
    }
    public function  AddPAction(Request $request)
    {
        $project=$this->getDoctrine()->getRepository('ProjectBundle:Project')->findAll();
        $p= new Project();
        $Form=$this->createForm(ProjectType::class,$p);
        $Form->handleRequest($request);


        if ($Form->isSubmitted() ) {
            $em = $this->getDoctrine()->getManager();
            $p->setCreated(new \DateTime('now'));
            $em->persist($p);
            $em->flush();
            return $this->redirectToRoute('addProject');
        }


        return $this->render('@Project/Default/createProject.html.twig',array('f'=>$Form->createView(),'p'=>$project));

    }

    public function ArchivePAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $project=$em->getRepository(Project::class)->find($id);
        $em->remove($project);
        $em->flush();
        return $this->redirectToRoute('@Project/Default/createProject.html.twig');

    }
}
