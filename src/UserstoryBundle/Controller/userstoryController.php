<?php

namespace UserstoryBundle\Controller;

use http\Env\Response;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use PHPMailer\PHPMailer\PHPMailer;
use UserstoryBundle\Entity\feature;
use UserstoryBundle\Entity\userstory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use UserstoryBundle\Entity\userstorycomment;

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
    //hada aff w ajout user story 3awed jareb
    public function indexAction(feature $feature)
    {
        $em = $this->getDoctrine()->getManager();
        $userstories =$em->getRepository('UserstoryBundle:userstory')->findBy(['isDeleted' => 0,'feature'=>$feature->getId()]);


        return $this->render('@Userstory/userstory/index.html.twig', array(
            'userstories' => $userstories,
            'feature' => $feature

        ));
    }

    public function addUserStoryAction(Request $request,feature $feature){
        $userstory = new userstory();
        $form=$this->createForm('UserstoryBundle\Form\userstoryType',$userstory);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $userstory->setIsDeleted(0);
            $userstory->setFeature($feature);
            $em->persist($userstory);
            $em->flush($userstory);



            return $this->redirectToRoute('userstory_index',array('id' => $feature->getId())) ;
        }
        return $this->render('@Userstory/userstory/new.html.twig', array(
            'f'=> $form->CreateView(),
            'userstory' => $userstory,
            'feature' => $feature

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
        $userstory = new userstory();
        $form = $this->createForm('UserstoryBundle\Form\userstoryType', $userstory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userstory->setIsDeleted(0);
            $em->persist($userstory);
            $em->flush();
            $this->mailAction();

            return $this->redirectToRoute('userstory_show', array('id' => $userstory->getId()));
        }

        return $this->render('@Userstory/userstory/index.html.twig', array(
            'userstory' => $userstory,
            'form' => $form->createView(),
        ));
    }
    public function mailAction()
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP
        $mail->SMTPOptions = array('ssl' =>
            array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true));
        $mail->Host = 'smtp.gmail.com'; // Spécifier le serveur SMTP
        $mail->SMTPAuth = true; // Activer authentication SMTP
        $mail->Username = 'amine.ghribi1@esprit.tn'; // Votre adresse email d'envoi
        $mail->Password = '193JMT0980'; // Le mot de passe de cette adresse email
        $mail->SMTPSecure = 'ssl'; // Accepter SSL
        $mail->Port = 465;

        $mail->setFrom('moez.jouini@esprit.tn', 'user story'); // Personnaliser l'envoyeur
        //$em = $this->getDoctrine()->getManager();
        //$clients = $em->getRepository('MoezBackBundle:promotion')->findAll();
            $mail->addAddress('amine.ghribi1@esprit.tn'); // Ajouter le destinataire


        $mail->isHTML(true); // Paramétrer le format des emails en HTML ou non

        $mail->Subject = 'Nouvelle ';
        $mail->Body = 'qqqqq' ;

        $mail->SMTPDebug = 1;

        if(!$mail->send()) {
            echo 'Erreur, message non envoyé.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Le message a bien été envoyé !';
        }
    }
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
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $userstory = $em->getRepository('UserstoryBundle:userstory')->find($id);

        $editForm = $this->createForm('UserstoryBundle\Form\userstoryType', $userstory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userstory_edit', array('id' => $userstory->getId()));
        }

        return $this->render('@Userstory/userstory/edit.html.twig', array(
            'userstory' => $userstory,
            'edit_form' => $editForm->createView(),

        ));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userstory = $em->getRepository('UserstoryBundle:userstory')->find($id);
        $userstory->setIsDeleted(1);
        $em->flush();
        return $this->redirectToRoute('userstory_index', array('id' => $userstory->getFeature()->getId()));
    }

    public function PdfAction(){
        $em = $this->getDoctrine()->getManager();
        $filename= 'snappypdf';
        $userstories = $em->getRepository('UserstoryBundle:userstory')->findBy( ['isDeleted' => 0]);

        $snappy = $this->get('knp_snappy.pdf');
        $html = $this->render('@Userstory/userstory/index.html.twig',array(
                'userstories' => $userstories,
            )

        );
        return new PdfResponse(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="'.$filename.'.pdf"'
            )
        );

    }
    public function BackAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $userstory = new userstory();
        $form = $this->createForm('UserstoryBundle\Form\userstoryType', $userstory);
        $form->handleRequest($request);

        $userstories = $em->getRepository('UserstoryBundle:userstory')->findBy( ['isDeleted' => 0]);
        return $this->render('@Userstory/userstory/back.html.twig', array(
            'userstories' => $userstories,
            'form' => $form->createView(),


        ));


    }


}
