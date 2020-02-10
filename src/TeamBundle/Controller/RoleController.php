<?php

namespace TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TeamBundle\Entity\role;
use TeamBundle\Form\roleType;

class RoleController extends Controller
{
    public function ajoutRoleAction(Request $request)
    {
        $role = new role();
        $form = $this->createForm(roleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

           // return $this->redirectToRoute('role_show', array('id' => $role->getId()));
        }

        return $this->render("/role/addRole.html.twig", array(
            'role' => $role,
            'form' => $form->createView(),
        ));
    }
}
