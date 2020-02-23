<?php

namespace ForumBundle\Controller;


use Doctrine\DBAL\Types\DateTimeImmutableType;
use ForumBundle\Entity\Answer;
use ForumBundle\Entity\Categories;
use ForumBundle\Entity\Question;
use ForumBundle\Form\AnswerType;
use ForumBundle\Form\CategoriesType;
use ForumBundle\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ActivityBundle\Service\ActivityGenerator;
use Twilio\Rest\Client;
class QuestionController extends Controller
{

    public function DisplayQuestionsAction()
    {

        $provider = $this->container->get('fos_message.provider');
        $nbr = $provider->getNbUnreadMessages();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $questions=$this->getDoctrine()
            ->getRepository(Question::class)->getOtherQuestions($user);
        $myQuestions=$this->getDoctrine()
            ->getRepository(Question::class)
            ->findBy(['User' => $user]);

        $categories = $this->getDoctrine()->getRepository(Categories::class)
            ->findAll();
        return $this->render('@Forum/Question/display_questions.html.twig',
            array('questions'=>$questions, 'user' => $user,'myQuestions'=>$myQuestions,'nbr'=>$nbr, 'categories'=>$categories  ));
    }
    public function DisplayBackQuestionsAction( Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $questions=$this->getDoctrine()
            ->getRepository(Question::class)
            ->findAll();

        $category = new Categories();
        $Form=$this->createForm(CategoriesType::class,$category);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid()){
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('_display_back_questions');

        }


        return $this->render('@Forum/back/back.html.twig',
            array('questions'=>$questions, 'user' => $user, 'f'=>$Form->createView() ));
    }

    public function DisplayQuestionAction($id, Request $request)
    {
        $answer = new Answer();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em=$this->getDoctrine()->getManager();
        $question =$em->getRepository('ForumBundle:Question')->find($id);

        $question->setViews($question->getViews() + 1);
        $em->flush();
        $categories = $this->getDoctrine()->getRepository(Categories::class)
            ->findAll();

        $answers = $em->getRepository('ForumBundle:Answer')->findBy(['Question'=>$question]);
        $Form2=$this->createForm(AnswerType::class,$answer);
        $Form2->handleRequest($request);
        if($Form2->isSubmitted() && $Form2->isValid()){
            $answer ->setQuestion($question);
            $answer->setUser($user);
            $answer->setAnswerDate(new \DateTime());
            $em->persist($answer);
            $em->flush();
            $activityGenerator = $this->get(ActivityGenerator::class);
            $activity = $activityGenerator->AjouterActivity('a ajouter une reponse', $user);
            $this->addFlash('success', $activity);
            return $this->redirectToRoute('_display_question',['id' => $id]);


        }
        return $this->render('@Forum/Question/display_question.html.twig',array(
            'question'=> $question, 'f2'=>$Form2->createView(), "answers"=>$answers, 'user' => $user, 'categories' => $categories));
    }
    public function AddQuestionAction(Request $request)
    {

        $question = new Question() ;
        $question->setDislikes(0);
        $question->setLikes(0);
        $question->setViews(0);
        $question->setQuestionDate(new \DateTime());
        $em=$this->getDoctrine()->getManager();
        $Form=$this->createForm(QuestionType::class,$question);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid()){
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $question->setUser($user);
            $em->persist($question);
            $em->flush();
            $activityGenerator = $this->get(ActivityGenerator::class);
            $activity = $activityGenerator->AjouterActivity('a ajouter un question', $user);
            $this->addFlash('success', $activity);
            return $this->redirectToRoute('_display_questions');
        }

        return $this->render('@Forum/Question/add_question.html.twig',
            array('f'=>$Form->createView()));
    }

    public function DeleteQuestionAction($id){
        $activityGenerator = $this->get(ActivityGenerator::class);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $activity = $activityGenerator->AjouterActivity('a supprimer un question', $user);
        $this->addFlash('success', $activity);
        $em=$this->getDoctrine()->getManager();
        $question=$em->getRepository(Question::class)
            ->find($id);
        $em->remove($question);
        $em->flush();
        return $this->redirectToRoute('_display_questions');
    }
    public function EditQuestionAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository(Question::class)
            ->find($id);
        $Form = $this->createForm(QuestionType::class, $question);
        $Form->handleRequest($request);

        if ($Form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('_display_questions');

        }
        return $this->render('@Forum/Question/edit_question.html.twig',
            array('f' => $Form->createView()));


    }


}
