<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('@Main/Default/index.html.twig');
    }
    /**
     * @Route("/register")
     */
    public function loginAction()
    {
        return $this->render('@Main/Security/login.html.twig');
    }
    public function registerAction()
    {
        return $this->render('@Main/Registration/register.html.twig');
    }
    public function contactAction( Request $request)
    {
        $p= new Contact();
        $f=$this->createForm('MainBundle\Form\ContactType',$p);
        $f->handleRequest($request);

        if ($f->isSubmitted() && $f->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $p->setSend(new \DateTime('now'));
            $p->setReplied(new \DateTime('now'));
            $p->setStatus('Send');
            $p->setEtat(1);
            $em->persist($p);
            $em->flush($p);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('@Main/Default/index.html.twig',array(
            'p'=>$f->CreateView()

        ));

            return $this->render('@Main/Default/index.html.twig',array(
                'p'=>$f->CreateView()

            ));

    }


}
