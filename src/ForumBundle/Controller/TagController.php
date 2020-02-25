<?php

namespace ForumBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{
    /**
     * @Route("/tags.json", name="tag.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction(Request $request){
        $tagRepository = $this->getDoctrine()->getRepository('ForumBundle:Tag');
        $tags = $tagRepository->findAll();
        return $this->json($tags, 200, [], ['groups'=>['public']]);

    }
}
