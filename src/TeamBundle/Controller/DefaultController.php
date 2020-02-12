<?php

namespace TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TeamBundle\Entity\role;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Team/Role/index.html.twig');
    }

    public function affRoleAction(Request $request)
    {
        $p= new role();
        $form = $this->createFormBuilder($p)

            ->add('role', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "name"))

            ->add('Ajouter', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {

            $p->setInd(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($p);

            $em->flush();
            return $this->redirectToRoute("affiche_role");
        }
        $con = $this -> getDoctrine()->getRepository('TeamBundle:role')->findAll();
        return $this->render('@Team/Role/createRole.html.twig',array('con'=> $con,"form" => $form->createView()));

    }

    public function  AddPAction(Request $request)
    {
        $project=$this->getDoctrine()->getRepository(role::class)->findAll();
        $p= new role();
        $form = $this->createFormBuilder($p)

            ->add('role', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "name"))

            ->add('Ajouter', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $p->setInd(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            return $this->redirectToRoute("ajout_team");

        }

        return $this->render('@Team/Role/createRole.html.twig',array("form" => $form->createView())
        );
  
}

    public function  editAction(Request $request,$id)
    {
        {
            $con = $this -> getDoctrine()->getRepository('TeamBundle:role')->find($id);
            $con->setRole($con->getRole());


            $form = $this->createFormBuilder($con)

                ->add('role', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "name"))


                ->add('Modifier', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))
                ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $con->setInd(0);

                $em = $this->getDoctrine()->getManager();

                $em->flush();
                return $this->redirectToRoute("affiche_role");

            }
            return $this->render('@Team/role/edit.html.twig',array("form" => $form->createView()));

        }

    }

    public function archiveAction(Request $request, $id){

        $con = $this -> getDoctrine()->getRepository('TeamBundle:role')->find($id);
        $em = $this->getDoctrine()->getManager();
        $con->setInd(1);
        $em->persist($con);
        $em->flush();
        return $this->redirectToRoute('affiche_role');
    }
}
