<?php

namespace UserstoryBundle\Controller;

use UserstoryBundle\Entity\feature;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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
        $feature = new Feature();
        $form = $this->createForm('UserstoryBundle\Form\featureType', $feature);
        $form->handleRequest($request);

        $features = $em->getRepository('UserstoryBundle:feature')->findAll();

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
    public function newAction(Request $request)
    {
        $feature = new Feature();
        $form = $this->createForm('UserstoryBundle\Form\featureType', $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    /**
     * Finds and displays a feature entity.
     *
     * @Route("/{id}", name="feature_show")
     * @Method("GET")
     */
    public function showAction(feature $feature)
    {
        $deleteForm = $this->createDeleteForm($feature);

        return $this->render('@userstory/feature/show.html.twig', array(
            'feature' => $feature,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing feature entity.
     *
     * @Route("/{id}/edit", name="feature_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, feature $feature)
    {
        $deleteForm = $this->createDeleteForm($feature);
        $editForm = $this->createForm('UserstoryBundle\Form\featureType', $feature);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('feature_edit', array('id' => $feature->getId()));
        }

        return $this->render('@Userstory/feature/edit.html.twig', array(
            'feature' => $feature,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
            $userstory = $em->getRepository('UserstoryBundle:userstory')->find($id);
            $userstory->setIsDeleted(1);
            $em->flush();
        return $this->redirectToRoute('userstory_index');
    }

}
