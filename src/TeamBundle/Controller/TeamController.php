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
            ->add('etat', IntegerType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "etat"))

            ->add('Ajouter', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $p->setCreated(new \DateTime('now'));
            $p->setUpdated(new \DateTime('now'));

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
            ->add('etat', IntegerType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "etat"))

            ->add('Ajouter', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {

            $p->setCreated(new \DateTime('now'));
            $p->setUpdated(new \DateTime('now'));
           $p->setInd(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            var_dump($p);
            $em->flush();
            return $this->redirectToRoute("affiche_team");
        }
        $con = $this -> getDoctrine()->getRepository('TeamBundle:team')->findAll();
        return $this->render('@Team/team/index.html.twig',array('con'=> $con,"form" => $form->createView()));
    }
    public function  editAction(Request $request,$id)
    {
        {
            $con = $this -> getDoctrine()->getRepository('TeamBundle:team')->find($id);
            $con->setName($con->getName());
            $con->setEtat($con->getEtat());

            $form = $this->createFormBuilder($con)

                ->add('name', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "name"))
                ->add('etat', IntegerType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "etat"))

                ->add('Modifier', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))
                ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $con->setUpdated(new \DateTime('now'));

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

        $taskB=$this->getDoctrine()->getRepository(team::class)->findAll();


        return $this->render('@Team/team/back.html.twig',array(
            'pp'=>$taskB

        ));
}

}
