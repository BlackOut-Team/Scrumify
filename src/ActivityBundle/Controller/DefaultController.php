<?php

namespace ActivityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Activity/Default/index.html.twig');
    }
    public function AfficherAction()
    {
        return $this->render('@Activity/Default/meetings.html.twig');
    }
}
