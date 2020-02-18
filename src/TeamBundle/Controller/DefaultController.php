<?php

namespace TeamBundle\Controller;

use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TeamBundle\Entity\role;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends Controller
{
    public function affecterAction($id,Request $request)
    {
        $con = $this -> getDoctrine()->getRepository('TeamBundle:team')->find($id);
        $con1 = new User;

        $form = $this->createFormBuilder($con1)

            ->add('email', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "email"))
            ->add('Ajouter', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            dump('taraya');exit;
            
        }

        return $this->render('@Team/Default/affMembre.html.twig',array("form" => $form->createView()));
    }
}
