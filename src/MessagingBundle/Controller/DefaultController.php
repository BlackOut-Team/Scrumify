<?php

namespace MessagingBundle\Controller;

use MessagingBundle\Entity\FriendShip;
use MessagingBundle\Entity\Message;
use MessagingBundle\Entity\Thread;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\MessageBundle\FormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer;


class DefaultController extends Controller
{
    public function indexAction($id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $thread =$this->container->get('fos_message.provider')->getThread($id);
        $thread->getLastMessage()->SetIsReadByParticipant($user, 1);
        $form = $this->container->get('fos_message.reply_form.factory')->create($thread);
        $formHandler = $this->container->get('fos_message.reply_form.handler');
        $em=$this->getDoctrine()->getManager();

        $friendRequest = $em->getRepository(FriendShip::class)->findBy(['friend' => $user, 'isFriend' => 0]);


        if ($message = $formHandler->process($form)) {
            return new RedirectResponse($this->container->get('router')->generate('messaging_homepage', array(
                'id' => $message->getThread()->getId(),
            )));

        }

        $provider = $this->container->get('fos_message.provider');
        $threadsInbox = $provider->getInboxThreads();
        $threads = $provider->getSentThreads();
        return $this->render('@Messaging/Default/chat.html.twig', array(
            'form' => $form->createView(),
            'thread' => $thread,
            'threads' => $threads,
            'user' =>$user,
            'requests' => $friendRequest,
            'threadsInbox' => $threadsInbox
        ));
    }


    public function refreshAction(Request $request){
        $normalizer = new ObjectNormalizer(null);
        $normalizer->setIgnoredAttributes(array('thread', 'createdAt', 'allMetadata'));
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $encoder = new JsonEncoder();
//$serializer = $this->get('serializer');
        $serializer = new Serializer(array($normalizer), array($encoder));
        $threadId =$request->request->get('thread');
        $thread =$this->container->get('fos_message.provider')->getThread($threadId);
        if ($request->isXmlHttpRequest() ) {
            $em=$this->getDoctrine()->getManager();

            $Content = $em->createQueryBuilder()->select('p')
                ->from('MessagingBundle:Message', 'p')
                ->where('p.thread= :id')
                ->setParameter('id', $threadId)
                ->getQuery()
                ->getResult();
            $jsonContent = $serializer->serialize($Content, 'json');
            $response =new JsonResponse($jsonContent) ;
            $response->headers->set('Content-Type', 'application/json');

            return $response;

        } else {
            return $this->render('student/ajax.html.twig');
        }
    }



    public function replyAction(Request $request){

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $composer = $this->container->get('fos_message.composer');
        $threadId =$request->request->get('thread');
        $messageBody =$request->request->get('message');
        if ($request->isXmlHttpRequest() ) {
            $thread =$this->container->get('fos_message.provider')->getThread($threadId);
            $message = $composer->reply($thread)
                ->setSender($user)
                ->setBody($messageBody)
                ->getMessage();
            $sender = $this->container->get('fos_message.sender');
            $sender->send($message);
            return new Response() ;
        } else {
            return $this->render('student/ajax.html.twig');
        }
    }
    public function inboxAction(){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em=$this->getDoctrine()->getManager();

        $friendRequest = $em->getRepository(FriendShip::class)->findBy(['friend' => $user, 'isFriend' => 0]);

        $provider = $this->container->get('fos_message.provider');
        $threadsInbox = $provider->getInboxThreads();
        $threads = $provider->getSentThreads();
        return $this->render('@Messaging/Default/inbox.html.twig', array(
            'threads' => $threads,
            'user' =>$user,
            'threadsInbox'=>$threadsInbox,
            'requests' => $friendRequest

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
