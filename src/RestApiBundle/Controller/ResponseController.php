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
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
     * @ApiDoc(
     *  description="Returns all responses",
     *  requirements={
     *      {
     *          "name"="app_key",
     *          "dataType"="String",
     *          "requirement"="true",
     *          "description"="Unique APP_KEY. For example: NACOFXYLPJGQERVBISKTWUHDZM."
     *      }
     *  },
     * )
     * @param Application $application
     * @return mixed
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function allResponseAction(Application $application = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'), 404);
        }
        $responses = $application->getResponses();

        return $this->success($responses, 'response', Response::HTTP_OK, array('Default', 'Details'));

    }

    /**
     * @ApiDoc(
     *  description="Returns response",
     *  requirements={
     *      {
     *          "name"="app_key",
     *          "dataType"="String",
     *          "requirement"="true",
     *          "description"="Unique APP_KEY. For example: NACOFXYLPJGQERVBISKTWUHDZM."
     *      },
     *      {
     *          "name"="id",
     *          "dataType"="Integer",
     *          "requirement"="true",
     *          "description"="Response id"
     *      }
     *  },
     * )
     * @param Application $application
     * @param \JSONMockBundle\Entity\Response $response
     * @return mixed
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     * @ParamConverter("response", class="JSONMockBundle\Entity\Response", options={"id" = "id"})
     */
    public function getResponseAction(Application $application = null, \JSONMockBundle\Entity\Response $response = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'), 404);
        }
        if ($response == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'Response not found'), 404);
        }
        $responses = $application->getResponses();
        if (!$responses->contains($response)) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'Response not found'), 404);
        }

        return $this->success($response, 'response', Response::HTTP_OK, array('Default', 'Details'));

    }

    /**
     * @ApiDoc(
     *  description="Create new response",
     *  requirements={
     *      {
     *          "name"="app_key",
     *          "dataType"="String",
     *          "requirement"="true",
     *          "description"="Unique APP_KEY. For example: NACOFXYLPJGQERVBISKTWUHDZM."
     *      }
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="Name of application"},
     *      {"name"="url", "dataType"="string", "required"=true, "description"="Path to application response"},
     *      {"name"="value", "dataType"="string", "required"=true, "description"="Value that endpoint should return"},
     *      {"name"="method", "dataType"="string", "required"=true, "description"="HTTP Methods. Allowed: GET, POST, PUT, DELETE"},
     *      {"name"="statusCode", "dataType"="string", "required"=true, "description"="HTTP Status Code."}
     *  })
     * )
     * @param Request $request
     * @param Application $application
     * @return mixed
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function createResponseAction(Request $request, Application $application = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'), 404);
        }
        $form = $this->get('form.factory')->create(new ResponseType());
        $formData = json_decode($request->getContent(), true);
        $formData['application'] = $application->getId();
        $form->submit($formData);

        if (!$form->isValid()) {
            return JsonResponse::create(array('status' => 'Error', 'message' => array_values($this->getErrorMessages($form))[0]), 400);
        }
        $response = $form->getData();

        $em = $this->getDoctrine()->getManager();
        $em->persist($response);
        $em->flush();

        return $this->success($response, 'response', Response::HTTP_CREATED, array('Default', 'Details'));
    }

    /**
     * @ApiDoc(
     *  description="Edit response",
     *  requirements={
     *      {
     *          "name"="app_key",
     *          "dataType"="String",
     *          "requirement"="true",
     *          "description"="Unique APP_KEY. For example: NACOFXYLPJGQERVBISKTWUHDZM."
     *      }
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="Name of application"},
     *      {"name"="url", "dataType"="string", "required"=true, "description"="Path to application response"},
     *      {"name"="value", "dataType"="string", "required"=true, "description"="Value that endpoint should return"},
     *      {"name"="method", "dataType"="string", "required"=true, "description"="HTTP Methods. Allowed: GET, POST, PUT, DELETE"},
     *      {"name"="statusCode", "dataType"="string", "required"=true, "description"="HTTP Status Code."}
     *  })
     * )
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
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'), 404);
        }
        if ($response == null || !$application->getResponses()->contains($response)) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'Response not found'), 404);
        }
        $form = $this->get('form.factory')->create(new ResponseType(), $response);
        $formData = json_decode($request->getContent(), true);
        $formData['application'] = $application->getId();
        $form->submit($formData);

        if (!$form->isValid()) {
            return JsonResponse::create(array('status' => 'Error', 'message' => array_values($this->getErrorMessages($form))[0]), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($response);
        $em->flush();

        return $this->success($response, 'application', Response::HTTP_OK, array('Default', 'Details'));
    }

    /**
     * @ApiDoc(
     *  description="Delete response",
     *  requirements={
     *      {
     *          "name"="app_key",
     *          "dataType"="String",
     *          "requirement"="true",
     *          "description"="Unique APP_KEY. For example: NACOFXYLPJGQERVBISKTWUHDZM."
     *      }
     * })
     * @param \JSONMockBundle\Entity\Response $response
     * @param Application $application
     * @return mixed
     * @ParamConverter("response", class="JSONMockBundle\Entity\Response", options={"id" = "id"})
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function deleteResponseAction(\JSONMockBundle\Entity\Response $response = null, Application $application = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'), 404);
        }
        if ($response == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'Response not found'), 404);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($response);
        $em->flush();

        return JsonResponse::create(array('status' => 'Success', 'message' => 'Response properly removed'), 200);
    }
}
