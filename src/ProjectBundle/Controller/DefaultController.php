<?php

namespace ProjectBundle\Controller;

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
    public function AddProjectAction(Request $request)
    {
        $project=new project();
        $Form=$this->createForm(ProjectType::class,$project);
        $Form->handleRequest($request);
        if($Form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            return $this->redirectToRoute('project_homepage');


        }
        return $this->render('@Project/Default/AddP.html.twig',
            array('f'=>$Form->createView()));
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
