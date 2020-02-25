<?php

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Activity;
use ActivityBundle\Entity\Meetings;
use FOS\UserBundle\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ActivityController extends Controller
{


    public function AfficherAction()
    {
        $Activities=$this->getDoctrine()
            ->getRepository(Activity::class)
            ->findAll();

        $meeting=$this->getDoctrine()
            ->getRepository(Meetings::class)
            ->findAll();
        return $this->render('@Activity/Default/activity.html.twig',
            array('activities'=>$Activities,'m'=>$meeting));
    }
    function SupprimerAction($id,$project_id){
        $em=$this->getDoctrine()->getManager();
        $Activity=$em->getRepository(Activity::class)
            ->find($id);
        $em->remove($Activity);
        $em->flush();
        return $this->redirectToRoute('affichermeeting', ['id' => $project_id]);

    }
    public function ChangeActivityStateAction($id, $project_id){
        $em = $this->getDoctrine()->getManager();
        $activity = $em->getRepository(Activity::class)
            ->find($id);
        $activity->setViewed(1);
        $em->flush();
        return $this->redirectToRoute('affichermeeting', ['id' => $project_id]);
    }
    public function getNotifAction(Request $request){
        if ($request->isXmlHttpRequest() ) {

            //convertir entity array -> json pour l'envoyer lel ajax
            $normalizer = new ObjectNormalizer(null);
            $normalizer->setIgnoredAttributes(array('notifiableEntity'));
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $encoder = new JsonEncoder();
            $serializer = new Serializer(array($normalizer), array($encoder));


            //online user
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $notifiableRepo = $this->getDoctrine()->getManager()->getRepository('MgiletNotificationBundle:NotifiableNotification');
            $notificationList = $notifiableRepo->findAllForNotifiable($user->getId(), \MainBundle\Entity\User::class );
            $jsonContent = $serializer->serialize($notificationList, 'json');

            $response =new JsonResponse($jsonContent) ;
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }


        return false ;

    }
}
