<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Question;
use ForumBundle\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends Controller
{
    public function DisplayQuestionsAction()
    {
        $questions=$this->getDoctrine()
            ->getRepository(Question::class)
            ->findAll();
        return $this->render('@Forum/Question/display_questions.html.twig',
            array('questions'=>$questions));
    }

    public function DisplayQuestionAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $question =$em->getRepository('ForumBundle:Question')->find($id);
        return $this->render('@Forum/Question/display_question.html.twig',array(
            'question'=> $question));
    }
    public function AddQuestionAction(Request $request)
    {


        return $this->render('@Forum/Question/add_question.html.twig');
    }


}
