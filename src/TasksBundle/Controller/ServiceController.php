<?php

namespace TasksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TasksBundle\Entity\Media;
use TasksBundle\Entity\Tasks;
use MainBundle\Entity\User;

use UserstoryBundle\Entity\userstory;

class ServiceController extends Controller
{
    public function showAction()
    {

        $task = $this->getDoctrine()->getManager()->getRepository('TasksBundle:Tasks')->findby(['etat'=>0]);
        $datas = array();
        foreach ($task as $key => $task){
            $datas[$key]['title'] = $task->getTitle();
            $datas[$key]['id'] = $task->getId();
            $datas[$key]['description'] = $task->getDescription();
            $datas[$key]['priority'] = $task->getpriority();
            #$datas[$key]['Categorie'] = $col->getNomcategorie()->getCategorie();
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($datas);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tasks = new Tasks();
        $user = new User();

        $userStory = new Userstory();
        $userStory = $em->getRepository('UserstoryBundle:Userstory')->findOneBy(['id'=>1]);
        $tasks->setEtat(0);
        $tasks->setTitle($request->get('title'));
        $tasks->setDescription($request->get('description'));
        $tasks->setCreated(new \DateTime('now'));
        $tasks->setStatus("Todo");
        $tasks->setUpdated(new \DateTime('now'));
        $tasks->setFinished(new \DateTime('now'));
        $tasks->setPriority($request->get('priority'));
        $tasks->setUserstory($userStory);

        $a = $em->getRepository('MainBundle:User')->find($request->get('user'));
        $user= $this->getDoctrine()->getManager()->getRepository('MainBundle:User')->findOneBy(['username'=>$a->getUsername()]);
        $usersToAffect =$em->getRepository('MainBundle:User')->findBy(['username'=>'']);
        array_push($usersToAffect,$user);
        $tasks->setUser($usersToAffect);

        $em->persist($tasks);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function updatedAction($Id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $find=  $this->getDoctrine()->getManager()->getRepository('TasksBundle:Tasks')->findBy(array('idT'=>$Id));
        foreach($find as $fin)
        {
            $fin->setTitle($request->get('title'));
            $fin->setDescription($request->get('description'));
        }
        $em->persist($fin);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($find);
        return new JsonResponse($formatted);
    }





    public function archiveAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $find=  $this->getDoctrine()->getManager()->getRepository('TasksBundle:Tasks')->findBy(array('id'=>$id));
        foreach($find as $fin)
        {
            $fin->setEtat(1);

        }
        $em->persist($fin);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($find);
        return new JsonResponse($formatted);
    }











    public function SupprimerAction($Id)
    {
        $em=$this->getDoctrine()->getManager();
        $find=  $this->getDoctrine()->getManager()->getRepository('TasksBundle:Tasks')->findBy(array('idT'=>$Id));
        foreach ($find as $col) {
            $em->remove($col);
        }
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($find);
        return new JsonResponse($formatted);
    }


}
