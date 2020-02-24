<?php

namespace TeamBundle\Controller;

use MainBundle\Entity\User;
use MyAppMailBundle\Entity\team_user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use TeamBundle\Entity\team;


class DefaultController extends Controller
{
    public function affecterAction($id,Request $request)
    {
        $con3 = $this->getDoctrine()->getRepository('MyAppMailBundle:team_user')->findBy(array('teamId' =>$id));

        $data=array();
        foreach ( $con3 as $item) {
            $a = array(
                'username'=> $this ->getDoctrine()->getRepository('MainBundle:User')->find($item->getUserId())->getUsername() ,
                'email'=>  $this ->getDoctrine()->getRepository('MainBundle:User')->find($item->getUserId())->getEmail()
            );
            array_push($data,$a);
        }


        $con = $this -> getDoctrine()->getRepository('TeamBundle:team')->find($id);
        $con1 = new User;
        $x = new team_user();

        $form = $this->createFormBuilder()

            ->add('email', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "email"))
            ->add('Ajouter', SubmitType::class, array( 'attr' => array('class' => 'template-btn', )))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $test=$this ->getDoctrine()->getRepository('MyAppMailBundle:team_user')->findBy(array('teamId'=>$id));


            $u = $this->getDoctrine()->getRepository('MainBundle:User')->findAll();
            foreach ($u as $y )
            {
                if($y->getEmail()!=$form['email']->getData())

                {
                    $con2 = $this ->getDoctrine()->getRepository('MainBundle:User')->findAll();
                    foreach ($con2 as $u) {

                        if(strtoupper($u->getEmail())==strtoupper($form['email']->getData()))
                        {

                            $message = \Swift_Message::newInstance()
                                ->setSubject('affectation au team')
                                ->setFrom('iheb.rekik@esprit.tn')
                                ->setTo($form['email']->getData())
                                ->setBody(
                                    $this->renderView('@MyAppMail/Mail/mail.html.twig',
                                        array('team' => $con->getName(),'text/html')));
                            $this->get('mailer')->send($message);

                            $x->setTeamId($id);
                            $x->setUserId($u->getId());
                            $em = $this->getDoctrine()->getManager();
                            $em->persist($x);
                            $em->flush();
                            return $this->redirectToRoute('affiche_team');

                        }else
                            $message = \Swift_Message::newInstance()
                                ->setSubject('affectation au team')
                                ->setFrom('iheb.rekik@esprit.tn')
                                ->setTo($form['email']->getData())
                                ->setBody(
                                    $this->renderView('@MyAppMail/Mail/mail1.html.twig',
                                        array('team' => $con->getName(),'text/html')));
                        $this->get('mailer')->send($message);
                    }

                }else
                {
                    return $this->redirectToRoute('show_team_back');


                }
            }




        }

        return $this->render('@Team/Default/affMembre.html.twig',array("form" => $form->createView(),"info"=>$data));
    }
}
