<?php

namespace UserstoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use UserstoryBundle\Entity\feature;
use UserstoryBundle\Entity\userstory;

class pdfController extends Controller
{


    public function indexAction()
    {

        $snappy = $this->get('knp_snappy.pdf');
        $filename = 'userstory';

        // use absolute path !
        $pageUrl = $this->generateUrl('pdf_body', array(), UrlGeneratorInterface::ABSOLUTE_URL);

        return new Response(
            $snappy->getOutput($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }
    public function indexFAction()
    {

        $snappy = $this->get('knp_snappy.pdf');
        $filename = 'Feature';

        // use absolute path !
        $pageUrl = $this->generateUrl('pdf_bodyF', array(), UrlGeneratorInterface::ABSOLUTE_URL);

        return new Response(
            $snappy->getOutput($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }

    public function pdfuserstoryAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $userstory = new userstory();
        $form = $this->createForm('UserstoryBundle\Form\userstoryType', $userstory);
        $form->handleRequest($request);

        $userstories = $em->getRepository('UserstoryBundle:userstory')->findBy( ['isDeleted' => 0]);
        return $this->render('@Userstory/userstory/pdf.html.twig', array(
            'userstories' => $userstories,
            'form' => $form->createView(),


        ));

    }

    public function pdfFeatureAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $feature = new feature();
        $form = $this->createForm('UserstoryBundle\Form\featureType', $feature);
        $form->handleRequest($request);

        $features = $em->getRepository('UserstoryBundle:feature')->findBy( ['isDeleted' => 0]);
        return $this->render('@Userstory/feature/pdf.html.twig', array(
            'features' => $features,
            'form' => $form->createView(),


        ));

    }




}
