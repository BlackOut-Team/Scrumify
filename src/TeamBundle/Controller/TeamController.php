<?php

namespace TeamBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use TeamBundle\Entity\team;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class TeamController extends Controller


{
    public function  AddPAction(Request $request)
    {
        $project=$this->getDoctrine()->getRepository(team::class)->findAll();
        $p= new team();
        $form = $this->createFormBuilder($p)

            ->add('name', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "name"))

            ->add('Ajouter', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $p->setCreated(new \DateTime('now'));
            $p->setUpdated(new \DateTime('now'));
            $p->setEtat(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            return $this->redirectToRoute("ajout_team");

        }



        //dump($f,$request);exit;
        return $this->render('@Team/team/ajoutTeam.html.twig',array("form" => $form->createView())
        );

    }
    public function affAction(Request $request)
    {
        $p= new team();
        $form = $this->createFormBuilder($p)

            ->add('name', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "name"))


            ->add('Ajouter', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))

            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) {



                $p->setCreated(new \DateTime('now'));
                $p->setUpdated(new \DateTime('now'));
                $p->setInd(0);
                $p->setEtat(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($p);

                $em->flush();
                return $this->redirectToRoute("affiche_team");
            } $this->addFlash('success', 'hahaha');


        $con = $this -> getDoctrine()->getRepository('TeamBundle:team')->findAll();
        return $this->render('@Team/team/index.html.twig',array('con'=> $con,"form" => $form->createView()));
    }
    public function affBAction(Request $request)
    {
        $p= new team();
        $form = $this->createFormBuilder($p)

            ->add('name', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "name"))
            ->add('Ajouter', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {

            $p->setCreated(new \DateTime('now'));
            $p->setUpdated(new \DateTime('now'));
            $p->setInd(0);
            $p->setEtat(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($p);

            $em->flush();
            return $this->redirectToRoute("affiche_team");
        }
        $con = $this -> getDoctrine()->getRepository('TeamBundle:team')->findAll();
        return $this->render('@Team/team/test.html.twig',array('con'=> $con,"form" => $form->createView()));
    }
    public function  editAction(Request $request,$id)
    {
        {
            $con = $this -> getDoctrine()->getRepository('TeamBundle:team')->find($id);
            $con->setName($con->getName());
            $con->setEtat($con->getEtat());

            $form = $this->createFormBuilder($con)

                ->add('name', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "name"))

                ->add('Modifier', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))
                ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted()) {

                $con->setUpdated(new \DateTime('now'));
                $con->setEtat(0);

                $em = $this->getDoctrine()->getManager();

                $em->flush();
                return $this->redirectToRoute("affiche_team");

            }
            return $this->render('@Team/team/edit.html.twig',array("form" => $form->createView()));

        }

    }
    public function archiveAction(Request $request, $id){

        $con = $this -> getDoctrine()->getRepository('TeamBundle:team')->find($id);
        $em = $this->getDoctrine()->getManager();
        $con->setInd(1);
        $em->persist($con);
        $em->flush();
        return $this->redirectToRoute('affiche_team');
    }

    public function archiveBAction(Request $request, $id){

        $con = $this -> getDoctrine()->getRepository('TeamBundle:team')->find($id);
        $em = $this->getDoctrine()->getManager();
        $con->setInd(1);
        $em->persist($con);
        $em->flush();
        return $this->redirectToRoute('show_team_back');
    }
    public function showbackAction (Request $request){

        // 1. Obtain doctrine manager
        $em = $this->getDoctrine()->getManager();
        // 2. Setup repository of some entity
        $repoTeam = $em->getRepository(team::class);
        // 3. Query how many rows are there in the Articles table
        $totalTeam = $repoTeam->createQueryBuilder('a')
            // Filter by some parameter if you want
            // ->where('a.published = 1')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $repoArch = $em->getRepository(team::class);
        // 3. Query how many rows are there in the Articles table
        $totalarchv = $repoArch->createQueryBuilder('a')
            // Filter by some parameter if you want
             ->where('a.ind = 1')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $team=$this->getDoctrine()->getRepository(team::class)->findAll();
         $persent=$totalarchv/$totalTeam*100;
//dump($persent);exit;
        return $this->render('@Team/team/back.html.twig',array(
            'pp'=>$team,
            'pr'=>$persent

        ));
}



    public function desarAction(Request $request, $id){

        $con = $this -> getDoctrine()->getRepository('TeamBundle:team')->find($id);
        $em = $this->getDoctrine()->getManager();
        $con->setInd(0);
        $em->persist($con);
        $em->flush();
        return $this->redirectToRoute('show_team_back');
    }

}
