<?php

namespace ForumBundle\Controller;


use ForumBundle\Entity\Question;
use ForumBundle\Form\QuestionType;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ActivityBundle\Service\ActivityGenerator;

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

        $question = new Question() ;

        $Form=$this->createForm(QuestionType::class,$question);
        $Form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        if($Form->isSubmitted() && $Form->isValid()){
            $user=$this->getDoctrine()
                ->getRepository(User::class)
                ->find(1);
            $question->setUser($user);
            $em->persist($question);
            $em->flush();
            $activityGenerator = $this->get(ActivityGenerator::class);
            $activity = $activityGenerator->AjouterActivity('question added');
            $this->addFlash('success', $activity);
            return $this->redirectToRoute('_display_questions');
        }

        return $this->render('@Forum/Question/add_question.html.twig',
            array('f'=>$Form->createView()));
    }


}
