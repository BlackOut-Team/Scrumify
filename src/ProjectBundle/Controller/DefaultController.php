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
    public function createPAction()
    {
        return $this->render('@Project/Default/createProject.html.twig');
    }
    public function  AddPAction(Request $request)
    {
        $p= new Project();
        $Form=$this->createForm(ProjectType::class,$p);
        $Form->handleRequest($request);


        if ($Form->isSubmitted() && $Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            $this->addFlash('info', 'Created Successfully !');
            return $this->redirectToRoute('project_homepage');
        }


        return $this->render('@Test/Default/add.html.twig',array(
         'f'=>$Form->createView()));

    }
    public function ShowPAction()
    {

        $project=$this->getDoctrine()->getRepository('ProjectBundle:Project')->findAll();


            return $this->render('@Project/Default/createProject.html.twig',
            array('p'=>$project));
    }

    public function ArchivePAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $project=$em->getRepository(Project::class)->find($id);
        $em->remove($project);
        $em->flush();
        return $this->redirectToRoute('@Project/Default/show_project.html.twig');

    }
}
