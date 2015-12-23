<?php

namespace Ben\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Ben\UserBundle\Form\UserType;

class MainController extends Controller
{

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function getFriendsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $this->container->get('ben_user.user.handler')->all();
        return $this->render('BenUserBundle:User:friends.html.twig', ['entities'=>$entities]);
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addFriendsAction(Request $request)
    {
        $currentUser = $this->getUser();
        $ids = $request->get('entities');
        $em = $this->getDoctrine()->getManager();

        foreach( $ids as $id) {
            $entity = $this->container->get('ben_user.user.handler')->get($id);
            $currentUser->addFriend($entity);
        }
        $em->persist($currentUser);
        $em->flush();

        return $this->redirect($this->generateUrl('friends'));
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteFriendsAction(Request $request)
    {
        $currentUser = $this->getUser();
        $ids = $request->get('entities');
        $em = $this->getDoctrine()->getManager();

        foreach( $ids as $id) {
            $entity = $this->container->get('ben_user.user.handler')->get($id);
            if($currentUser->isFriendWith($entity))
                $currentUser->removeFriend($entity);
        }
        $em->persist($currentUser);
        $em->flush();

        return $this->redirect($this->generateUrl('friends'));
    }


    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function editMeAction() {
        $currentUser = $this->getUser();
        $form = $this->createForm(UserType::class, $currentUser);
        return $this->render('BenUserBundle:user:edit.html.twig', array(
                    'entity' => $currentUser,
                    'form' => $form->createView(),
                ));
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function updateMeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entity = $this->getUser();
        // var_dump(2);die;
        $form = $this->createForm(UserType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('friends'));
        }
        return $this->render('BenUserBundle:user:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
    }

}
