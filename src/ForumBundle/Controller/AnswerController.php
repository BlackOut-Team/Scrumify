<?php

namespace ForumBundle\Controller;
use ActivityBundle\Service\ActivityGenerator;
use ForumBundle\Entity\Answer;
use ForumBundle\Form\AnswerType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AnswerController extends Controller
{
    public function DeleteAnswerAction($id){
        $activityGenerator = $this->get(ActivityGenerator::class);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $activity = $activityGenerator->AjouterActivity('a supprimer une reponse', $user);
        $this->addFlash('success', $activity);
        $em=$this->getDoctrine()->getManager();
        $answer=$em->getRepository(Answer::class)
            ->find($id);
        $em->remove($answer);
        $em->flush();
        return $this->redirectToRoute('_display_questions');
    }
    public function DisplayBackAnswersAction($question){
        $em=$this->getDoctrine()->getManager();

        $answers = $em->getRepository('ForumBundle:Answer')->findBy(['Question'=>$question]);
        return $this->render('@Forum/back/backAnswers.html.twig',array(
            'answers'=> $answers));
    }
}
