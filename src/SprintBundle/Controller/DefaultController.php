<?php

namespace SprintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Sprint/Default/index.html.twig');
    }
    public function indexPAction()
    {
        return $this->render('@Sprint/Default/index.html.twig');
    }
    public function createPAction()
    {
        return $this->render('@Sprint/Default/createProject.html.twig');
    }
    public function AddProjectAction(Request $request)
    {
        $sprint=new sprint();
        $Form=$this->createForm(SprintType::class,$sprint);
        $Form->handleRequest($request);
        if($Form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($sprint);
            $em->flush();
            return $this->redirectToRoute('project_homepage');


        }
        return $this->render('@Sprint/Default/AddProject.html.twig',
            array('f'=>$Form->createView()));
    }
    public function ShowPAction()
    {
        $sprint=$this->getDoctrine()->getRepository(Sprint::class)->findAll();
        return $this->render('@Sprint/Default/show_project.html.twig',
            array('p'=>$sprint));
    }

    public function ArchivePAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $project=$em->getRepository(Sprint::class)->find($id);
        $em->remove($sprint);
        $em->flush();
        return $this->redirectToRoute('@Project/Default/show_project.html.twig');

    }
}
