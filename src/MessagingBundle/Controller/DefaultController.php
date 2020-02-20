<?php

namespace MessagingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\MessageBundle\FormType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    public function indexAction($id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $thread =$this->container->get('fos_message.provider')->getThread($id);
        $form = $this->container->get('fos_message.reply_form.factory')->create($thread);
        $formHandler = $this->container->get('fos_message.reply_form.handler');

        if ($message = $formHandler->process($form)) {
            return new RedirectResponse($this->container->get('router')->generate('messaging_homepage', array(
                'id' => $message->getThread()->getId(),
            )));
        }


        $provider = $this->container->get('fos_message.provider');
        $threads = $provider->getInboxThreads();
        return $this->render('@Messaging/Default/chat.html.twig', array(
            'form' => $form->createView(),
            'thread' => $thread,
            'threads' => $threads,
            'user' =>$user,
        ));
    }
    public function inboxAction(){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $provider = $this->container->get('fos_message.provider');
        $threads = $provider->getInboxThreads();
        return $this->render('@Messaging/Default/inbox.html.twig', array(
            'threads' => $threads,
            'user' =>$user,
        ));
    }
    public function createThreadAction($id){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em=$this->getDoctrine()->getManager();
        $user2 =$em->getRepository('MainBundle:User')->find($id);
        $provider = $this->container->get('fos_message.provider');

        $composer = $this->container->get('fos_message.composer');
        $message = $composer->newThread()
            ->setSender($user)
            ->addRecipient($user2)
            ->setSubject('')
            ->setBody('Hi')
            ->getMessage();
        $sender = $this->container->get('fos_message.sender');
        $sender->send($message);


        $thread =$message->getThread();

        return $this->redirectToRoute('messaging_homepage',['id' => $thread->getId()]);


    }
}
