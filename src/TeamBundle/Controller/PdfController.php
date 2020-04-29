<?php

namespace TeamBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PdfController extends Controller
{

    public function indexAction()
    {

        $snappy = $this->get('knp_snappy.pdf');
        $filename = 'Team';

        // use absolute path !
        $pageUrl = $this->generateUrl('affiche_team', array(), UrlGeneratorInterface::ABSOLUTE_URL);

        return new Response(
            $snappy->getOutput($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }



}

