<?php

namespace UserstoryBundle\Controller;

use SprintBundle\Entity\Sprint;
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
    public function indexAction(Request $request,Sprint $sprint)
    {



        $em = $this->getDoctrine()->getManager();
        $feature = new Feature();
        $form = $this->createForm('UserstoryBundle\Form\featureType', $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feature->setSprint($sprint);
            $feature->setIsDeleted(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush($feature);

            return $this->redirectToRoute('feature_index', array('id' => $sprint->getId()));
        }

        $features = $this->getDoctrine()->getRepository(feature::class)->findBy(array('id'=>$sprint->getId()));
        return $this->render('@Userstory/feature/index.html.twig', array(
            'features' => $features,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new feature entity.
     *
     * @Route("/new", name="feature_new")
     * @Method({"GET", "POST"})
     */
    public function newAction($id ,Request $request)
    {
        $feature = new Feature();
        $form = $this->createForm('UserstoryBundle\Form\featureType', $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feature->setSprint($id);
            $feature->setIsDeleted(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush();

            return $this->redirectToRoute('feature_show', array('id' => $feature->getId()));
        }

        return $this->render('@Userstory/feature/new.html.twig', array(
            'feature' => $feature,
            'form' => $form->createView(),
        ));
    }
    public function getDeletedfeatureAction()
    {
        $em = $this->getDoctrine()->getManager();

        $features = $em->getRepository('UserstoryBundle:feature')->findBy( ['isDeleted' => 1]);

        return $this->render('@Userstory/feature/index.html.twig', array(
            'features' => $features,
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

        return $this->render('@Userstory/feature/show.html.twig', array(
            'feature' => $feature,

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

}
