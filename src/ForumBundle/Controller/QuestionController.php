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
    public function AddQuestionAction($id, Request $request)
    {

        $question=new Question();
        $question->setUser($id);
        $Form=$this->createForm(QuestionType::class,$question);
        $Form->add('Add ',SubmitType::class);
        $Form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        if($Form->isSubmitted() && $Form->isValid()){
            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute('_display_questions');
        }

        return $this->render('@Forum/Question/add_question.html.twig',
            array('f'=>$Form->createView()));
    }


}
