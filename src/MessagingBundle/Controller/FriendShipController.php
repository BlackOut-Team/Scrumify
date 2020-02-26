<?php

namespace MessagingBundle\Controller;

use MessagingBundle\Entity\FriendShip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FriendShipController extends Controller
{
    public function SendRequestAction(Request $request){
        $em=$this->getDoctrine()->getManager();


        $user = $this->getUser();
        if($request->isXmlHttpRequest()){
            $FriendId =$request->request->get('FriendId');
            $friend = $em->getRepository('MainBundle:User')->find($FriendId);
            $friendRequest = new FriendShip();
            $friendRequest->setUser($user);
            $friendRequest->setFriend($friend);
            $friendRequest->setIsFriend(0);
            $em->persist($friendRequest);
            $em->flush();
            return new JsonResponse(true);
        }
    }

    public function DisplayUsersAction(){
        $em=$this->getDoctrine()->getManager();

        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        $userId = $this->getUser();
        $friendRequest = $em->getRepository(FriendShip::class)->findBy(['friend' => $userId, 'isFriend' => 0]);
        $friends = $em->getRepository(FriendShip::class)->findBy(['isFriend' => 1]);

        $me = $this->getUser();
        $pending = $em->getRepository(FriendShip::class)->findBy(['user' => $userId, 'isFriend' => 0]);
        return $this->render('@Messaging/Default/all_users.html.twig', array(
            'users' => $users,
            //'friends' =>$friends,
            'pending' => $pending,
            'friendRequest' => $friendRequest,
            'me' => $me,
            'friends' =>$friends
        ));
    }

    public function AddFriendAction($id){
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser();

        $request = $em->getRepository(FriendShip::class)
            ->findOneBy(['friend' => $userId, 'user' => $id]);
        $request->setIsFriend(1);
        $em->flush();
        return $this->redirectToRoute('create_thread',['id' => $id ] );
    }
}
