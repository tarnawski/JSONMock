<?php

namespace RestApiBundle\Controller;

use RestApiBundle\Form\Type\ApplicationEditType;
use RestApiBundle\Form\Type\ApplicationType;
use JSONMockBundle\Entity\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RestApiBundle\Controller\ApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class ApplicationController
 */
class ApplicationController extends ApiController
{
    public function getEntityClassName()
    {
        return 'JSONMockBundle\Entity\Application';
    }

    /**
     * @ApiDoc(
     *  description="Returns application details",
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
     * @return Application
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function getApplicationAction(Application $application = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'), 404);
        }

        return $this->success($application, 'application', Response::HTTP_OK, array('Default','Details'));
    }

    /**
     * @ApiDoc(
     *  description="Add application and return it",
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="Name of application"}
     *  })
     * @param Request $request
     * @return mixed|Response
     */
    public function createApplicationAction(Request $request)
    {
        $form = $this->get('form.factory')->create(new ApplicationType());
        $formData = json_decode($request->getContent(), true);
        $form->submit($formData);

        if (!$form->isValid()) {
            return JsonResponse::create(array('status' => 'Error', 'message' => array_values($this->getErrorMessages($form))[0]), 400);
        }
        $data = $form->getData();
        $application = $this->get('app.application.factory')->create($data['name']);
        $response = $this->get('app.response.factory')->createFirst($application);
        $em = $this->getDoctrine()->getManager();
        $em->persist($application);
        $em->persist($response);
        $em->flush();

        return $this->success($application, 'application', Response::HTTP_CREATED, array('Default','Details'));
    }

    /**
     * @ApiDoc(
     *  description="Edit name of application",
     *  requirements={
     *      {
     *          "name"="app_key",
     *          "dataType"="String",
     *          "requirement"="true",
     *          "description"="Unique APP_KEY. For example: NACOFXYLPJGQERVBISKTWUHDZM."
     *      }
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="Name of application"}
     *  })
     * @param Request $request
     * @param Application $application
     * @return mixed|Response
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function editApplicationAction(Request $request, Application $application = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'), 404);
        }

        $form = $this->get('form.factory')->create(new ApplicationEditType(), $application);
        $formData = json_decode($request->getContent(), true);

        $form->submit($formData);

        if (!$form->isValid()) {
            return JsonResponse::create(array('status' => 'Error', 'message' => array_values($this->getErrorMessages($form))[0]), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($application);
        $em->flush();

        return $this->success($application, 'application', Response::HTTP_OK, array('Default','Details'));
    }

    /**
     * @ApiDoc(
     *  description="Delete application",
     *  requirements={
     *      {
     *          "name"="app_key",
     *          "dataType"="String",
     *          "requirement"="true",
     *          "description"="Unique APP_KEY. For example: NACOFXYLPJGQERVBISKTWUHDZM."
     *      }
     *  })
     * @param Application $application
     * @return mixed
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function deleteApplicationAction(Application $application = null)
    {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'), 404);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($application);
        $em->flush();

        return JsonResponse::create(array('status' => 'Success', 'message' => 'Application properly removed'), 200);
    }
}
