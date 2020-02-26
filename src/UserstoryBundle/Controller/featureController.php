<?php

namespace UserstoryBundle\Controller;

use Elastica\Response;
use UserstoryBundle\Entity\feature;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use UserstoryBundle\UserstoryBundle;

/**
 * Feature controller.
 *
 * @Route("feature")
 */
class featureController extends Controller
{
    /**
     * Lists all feature entities.
     *
     * @Route("/", name="feature_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $features =$em->getRepository('UserstoryBundle:Feature')->findBy(['isDeleted' => 0]);
        $feature = new Feature();
        $form=$this->createForm('UserstoryBundle\Form\featureType',$feature);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $feature->setIsDeleted(0);
            $em->persist($feature);
            $em->flush($feature);
            return $this->redirectToRoute('feature_index') ;
        }

        return $this->render('@Userstory/feature/index.html.twig', array(
            'features' => $features,
            'form'=> $form->CreateView(),
            'feature' => $feature
        ));
    }

    /**
     * Creates a new feature entity.
     *
     * @Route("/new", name="feature_new")
     * @Method({"GET", "POST"})
     */

    public function getDeletedfeatureAction(Request $request)
    {
        $feature=new feature();
        $form = $this->createForm('UserstoryBundle\Form\featureType', $feature);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        $features = $em->getRepository('UserstoryBundle:feature')->findBy( ['isDeleted' => 1]);

        return $this->render('@Userstory/feature/deleteback.html.twig', array(
            'features' => $features,
            'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a feature entity.
     *
     * @Route("/{id}", name="feature_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $feature = $em->getRepository('UserstoryBundle:feature')->find($id);
        $featureComments = $em->getRepository('UserstoryBundle:featurecomment')->findBy( ['feature' => $feature]);


        return $this->render('@Userstory/feature/show.html.twig', array(
            'feature' => $feature,
            'comments' => $featureComments,

        ));
    }

    /**
     * Displays a form to edit an existing feature entity.
     *
     * @Route("/{id}/edit", name="feature_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $feature = $em->getRepository('UserstoryBundle:feature')->find($id);
        $editForm = $this->createForm('UserstoryBundle\Form\featureType', $feature);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('feature_edit', array('id' => $feature->getId()));
        }

        return $this->render('@Userstory/feature/edit.html.twig', array(
            'feature' => $feature,
            'edit_form' => $editForm->createView(),

        ));
    }

    /**
     * Deletes a feature entity.
     *
     * @Route("/{id}", name="feature_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
            $em = $this->getDoctrine()->getManager();
            $userstory = $em->getRepository('UserstoryBundle:feature')->find($id);
            $userstory->setIsDeleted(1);
            $em->flush();
        return $this->redirectToRoute('feature_index');
    }
    public function BackAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $feature = new Feature();
        $form = $this->createForm('UserstoryBundle\Form\featureType', $feature);
        $form->handleRequest($request);

        $features = $em->getRepository('UserstoryBundle:feature')->findAll();

        return $this->render('@Userstory/feature/Back.html.twig', array(
            'features' => $features,
            'form' => $form->createView(),
        ));
    }
    public function ajout_commentfAction(Request $request,$id)
    {
        $commentText = $request->get("comment");
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $feature = $em->getRepository('UserstoryBundle:feature')->find($id);
        $comment = new featurecomment();
        $comment->setComment($commentText);
        $comment->setDate(new \DateTime('now'));
        $comment->setUser($usr);
        $comment->setFeature($feature);
        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute('feature_show', array('id' => $id));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $features =  $em->getRepository('UserstoryBundle:feature')->findEntitiesByString($requestString);
        if(!$features) {
            $result['feature']['error'] = "Post Not found :( ";
        } else {
            $result['feature'] = $this->getRealEntities($features);
        }

        return new Response(json_encode($result));
    }
    public function getRealEntities($feature){
        foreach ($feature as $features){
            $realEntities[$features->getId()] = [$features->getName(),$features->getTitle()];

        }
        return $realEntities;
    }

}