<?php

namespace UserstoryBundle\Controller;

use http\Env\Response;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\HttpFoundation\RedirectResponse;
use TasksBundle\Entity\Tasks;
use UserstoryBundle\Entity\feature;
use UserstoryBundle\Entity\userstory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use UserstoryBundle\Entity\userstorycomment;
use UserstoryBundle\Form\userstoryType;
use Swift_Message;
require_once('PHPMailer-master/src/PHPMailer.php');
require_once('PHPMailer-master/src/SMTP.php');
require 'PHPMailer-master/PHPMailerAutoload.php';
/**
 * Userstory controller.
 *
 * @Route("userstory")
 */
class userstoryController extends Controller
{
    /**
     * Lists all userstory entities.
     *
     * @Route("/", name="userstory_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $userstory = new Userstory();
        $form = $this->createForm('UserstoryBundle\Form\userstoryType', $userstory);
        $form->handleRequest($request);
        $this->PdfAction();


        $userstories = $em->getRepository('UserstoryBundle:userstory')->findBy( ['isDeleted' => 0]);
        return $this->render('@Userstory/userstory/index.html.twig', array(
            'userstories' => $userstories,
            'form' => $form->createView(),


        ));

    }
    public function getDeletedUserstoryAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userstories = $em->getRepository('UserstoryBundle:userstory')->findBy( ['isDeleted' => 1]);

        return $this->render('@Userstory/userstory/index.html.twig', array(
            'userstories' => $userstories,
        ));
    }

    /**
     * Creates a new userstory entity.
     *
     * @Route("/new", name="userstory_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $userstory = new Userstory();
        $form = $this->createForm('UserstoryBundle\Form\userstoryType', $userstory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userstory->setIsDeleted(0);
            $em->persist($userstory);
            $em->flush();
            $this->sendMailAction();

            return $this->redirectToRoute('userstory_show', array('id' => $userstory->getId()));
        }

        return $this->render('@Userstory/userstory/new.html.twig', array(
            'userstory' => $userstory,
            'form' => $form->createView(),
        ));
    }
    /**
    public function sendMailAction(Request $request) {
        $to = "amine.ghribi1@esprit.tn ";
        $mail = new mail();
        $form= $this->createForm(new userstoryType(), $mail);
        $request->get(‘request’);
        $form->handleRequest($request) ;
        if ($form->isValid()) {
            $message = Swift_Message::newInstance()
                ->setSubject($mail->getNom())
                ->setFrom($mail-> getFrom())
                ->setTo($to)
                ->setBody($mail->getText());
            $this->get('mailer')->send($message);
            return $this->render('@Userstory/userstory/index.html.twig', array('to' => $to,
                'from' => $mail-> getFrom()
            ));
        }
        return $this->redirect($this->generateUrl('userstory_index'));}
**/

    /**
     * Finds and displays a userstory entity.
     *
     * @Route("/{id}", name="userstory_show")
     * @Method("GET")
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $userstory = $em->getRepository('UserstoryBundle:userstory')->find($id);
        $userstoryComments = $em->getRepository('UserstoryBundle:userstorycomment')->findBy( ['userstory' => $userstory]);
        return $this->render('@Userstory/userstory/show.html.twig', array(
            'userstory' => $userstory,
            'comments' => $userstoryComments,
        ));
    }
    public function ajout_commentAction(Request $request,$id)
    {
        $commentText = $request->get("comment");
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $userstory = $em->getRepository('UserstoryBundle:userstory')->find($id);
        $comment = new userstorycomment();
        $comment->setComment($commentText);
        $comment->setDate(new \DateTime('now'));
        $comment->setUser($usr);
        $comment->setUserstory($userstory);
        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute('userstory_show', array('id' => $id));
    }

    /**
     * Displays a form to edit an existing userstory entity.
     *
     * @Route("/{id}/edit", name="userstory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, userstory $userstory)
    {
        $deleteForm = $this->createDeleteForm($userstory);
        $editForm = $this->createForm('UserstoryBundle\Form\userstoryType', $userstory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userstory_edit', array('id' => $userstory->getId()));
        }

        return $this->render('@Userstory/userstory/edit.html.twig', array(
            'userstory' => $userstory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userstory = $em->getRepository('UserstoryBundle:userstory')->find($id);
        $userstory->setIsDeleted(1);
        $em->flush();
        return $this->redirectToRoute('userstory_index');
    }

    public function PdfAction(){
        $em = $this->getDoctrine()->getManager();

        $userstories = $em->getRepository('UserstoryBundle:userstory')->findBy( ['isDeleted' => 0]);

        $snappy = $this->get('knp_snappy.pdf');
        $html = $this->render('@Userstory/userstory/pdf.html.twig',array(
                "title" => "backlog"
            )

        );

        $filename = "custom_twig";
        return new PdfResponse(
            $snappy-> getOutputFromHtml($html),
            200,
            array(
                'content-type' => 'application/pdf',
                'content-Disposition' => 'attachment; filename"'.$filename.'.pdf"'
            )
        );
   }
    /**public function PdfViewAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $userstory = $em->getRepository('UserstoryBundle:userstory')->find($id);
        $html = $this->renderView('@UserstoryBundle/userstory/pdf.html.twig', array(
            'userstory'=> $userstory,

        ));
        $filename = 'backlog.pdf';
        $pdf = $this->get("knp_snappy.pdf")->getOutputFromHtml($html);
        $user =$em->getRepository('UserstoryBundle:userstory')->find($this->getUser()->getId());

        # Setup the message
        $message = \Swift_Message::newInstance()
            ->setBody('Bonjour Mr/Mme new userstory ')
            ->setFrom('amine.ghribi1@esprit.tn')
            ->setTo('amine.ghribi1@esprit.tn')
            ->setSubject('new userstory');

        $attachement = \Swift_Attachment::newInstance($pdf, $filename, 'application/pdf' );
        $message->attach($attachement);

        # Send the message
        $this->get('mailer')->send($message);
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
**/
    public function showUserstoryAction (Request $request){

        $userstory=$this->getDoctrine()->getRepository('UserstoryBundle:userstory')->findBy( ['isDeleted' => 0]);


        return $this->render('@Userstory/userstory/back.html.twig',array(
            'pp'=>$userstory
        ));
    }


}
