<?php

namespace RestApiBundle\Controller;

use JSONMockBundle\Entity\ResponseRepository;
use JSONMockBundle\Entity\Application;
use RestApiBundle\Form\Type\ResponseType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RestApiBundle\Controller\ApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ResponseController
 */
class ResponseController extends ApiController
{
    public function getEntityClassName()
    {
        return 'JSONMockBundle\Entity\Response';
    }

    /**
     * @param Application $application
     * @return mixed
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function allResponseAction(Application $application = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'));
        }
        $responses = $application->getResponses();

        return $this->success($responses, 'response', Response::HTTP_OK, array('Default', 'Details'));

    }

    /**
     * @param Application $application
     * @param \JSONMockBundle\Entity\Response $response
     * @return mixed
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     * @ParamConverter("response", class="JSONMockBundle\Entity\Response", options={"id" = "id"})
     */
    public function getResponseAction(Application $application = null, \JSONMockBundle\Entity\Response $response = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'));
        }
        if ($response == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'Response not found'));
        }
        $responses = $application->getResponses();
        if (!$responses->contains($response)) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'Response not found'));
        }

        return $this->success($response, 'response', Response::HTTP_OK, array('Default', 'Details'));

    }

    /**
     * @param Request $request
     * @param Application $application
     * @return mixed
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function createResponseAction(Request $request, Application $application = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'));
        }
        $form = $this->get('form.factory')->create(new ResponseType());
        $formData = json_decode($request->getContent(), true);
        $form->submit($formData);

        if (!$form->isValid()) {
            return $this->error($this->getErrorMessages($form));
        }
        $data = $form->getData();

        $response = $this->get('app.response.factory')->create($data);

        if ($response == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'This method exist'));
        }

        $response->setApplication($application);

        $em = $this->getDoctrine()->getManager();
        $em->persist($response);
        $em->flush();

        return $this->success($response, 'response', Response::HTTP_OK, array('Default', 'Details'));

    }

    /**
     * @param Request $request
     * @param \JSONMockBundle\Entity\Response $response
     * @param Application $application
     * @return mixed|Response
     * @ParamConverter("response", class="JSONMockBundle\Entity\Response", options={"id" = "id"})
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function editResponseAction(
        Request $request,
        \JSONMockBundle\Entity\Response $response = null,
        Application $application = null
    ) {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'));
        }
        if ($response == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'Response not found'));
        }
        $form = $this->get('form.factory')->create(new ResponseType(), $response);
        $formData = json_decode($request->getContent(), true);

        $form->submit($formData);

        if (!$form->isValid()) {
            return $this->error($this->getErrorMessages($form));
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($response);
        $em->flush();

        return $this->success($response, 'application', Response::HTTP_OK, array('Default', 'Details'));
    }

    /**
     * @param \JSONMockBundle\Entity\Response $response
     * @param Application $application
     * @return mixed
     * @ParamConverter("response", class="JSONMockBundle\Entity\Response", options={"id" = "id"})
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function deleteResponseAction(\JSONMockBundle\Entity\Response $response = null, Application $application = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'));
        }
        if ($response == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'Response not found'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($response);
        $em->flush();

        return JsonResponse::create(array('status' => 'Removed', 'message' => 'Response properly removed'));
    }
}
