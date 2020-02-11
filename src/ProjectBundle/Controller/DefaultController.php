<?php

namespace ProjectBundle\Controller;

use ActivityBundle\Entity\Activity;
use ProjectBundle\Entity\Project;
use ProjectBundle\Form\ProjectType;
use ProjectBundle\ProjectBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function  AddPAction(Request $request)
    {
        $project=$this->getDoctrine()->getRepository(Project::class)->findAll();
        $p= new Project();
        $f=$this->createForm('ProjectBundle\Form\ProjectType',$p);
        //dump($f,$request);exit;
        $f->handleRequest($request);
        if ($f->isSubmitted() && $f->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $p->setCreated(new \DateTime('now'));
            $em->persist($p);
            $em->flush($p);

            return $this->redirectToRoute('addProject');

        }
        return $this->render('@Project/Default/createProject.html.twig',array(
            'f'=>$f->createView(),
            'project'=>$project

        ));

    }

    public function archiverPAction(Request $request, Project $project){

        $em= $this->getDoctrine()->getManager();
        $project->setEtat(1);
        $em->persist($project);
        $em->flush();
        return $this->redirectToRoute('addProject');

    }
}
