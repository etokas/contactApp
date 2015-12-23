<?php
namespace Ben\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations\View;

use FOS\RestBundle\Controller\FOSRestController;

class UserRestController extends FOSRestController
{
    /**
    * @View(serializerGroups={"list"})
    */
    public function getUsersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $this->container->get('ben_user.user.handler')->all();
        return $entities;
    }

    /**
    * @View(serializerGroups={"detail"})
    */
    public function getUserAction($id)
    {
        $entity = $this->getOr404($id);

        return $entity;
    }

    public function newUserAction()
    {
        return $this->createForm(new UserType());
    }

    public function postUserAction(Request $request)
    {
        try {
            $newUser = $this->container->get('ben_user.user.handler')->post(
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $newUser->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_get_user', $routeOptions, Codes::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    public function putUserAction(Request $request, $id)
    {
        try {
            if (!($entity = $this->container->get('ben_user.user.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $entity = $this->container->get('ben_user.user.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $entity = $this->container->get('ben_user.user.handler')->put(
                    $entity,
                    $request->request->all()
                );
            }

            $routeOptions = array(
                'id' => $entity->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_get_user', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }


    public function patchUserAction(Request $request, $id)
    {
        try {
            $entity = $this->container->get('ben_user.user.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $entity->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_get_user', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    protected function getOr404($id)
    {
        if (!($entity = $this->container->get('ben_user.user.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $entity;
    }

}
