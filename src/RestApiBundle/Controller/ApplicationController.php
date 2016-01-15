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
     * @param Application $application
     * @return Application
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function getApplicationAction(Application $application = null)
    {
        if($application == null){
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'));
        }

        return $this->success($application, 'application', Response::HTTP_OK, array('Default','Details'));
    }

    /**
     * @param Request $request
     * @return mixed|Response
     */
    public function createApplicationAction(Request $request)
    {
        $form = $this->get('form.factory')->create(new ApplicationType());
        $formData = json_decode($request->getContent(), true);
        $form->submit($formData);

        if (!$form->isValid()) {
            return $this->error($this->getErrorMessages($form));
        }
        $data = $form->getData();
        $application = $this->get('app.user.factory')->create($data['name']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($application);
        $em->flush();

        return $this->success($application, 'application', Response::HTTP_OK, array('Default','Details'));
    }

    /**
     * @param Request $request
     * @param Application $application
     * @return mixed|Response
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function editApplicationAction(Request $request, Application $application = null)
    {
        if($application == null){
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'));
        }

        $form = $this->get('form.factory')->create(new ApplicationEditType(), $application);
        $formData = json_decode($request->getContent(), true);

        $form->submit($formData);

        if (!$form->isValid()) {
            return $this->error($this->getErrorMessages($form));
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($application);
        $em->flush();

        return $this->success($application, 'application', Response::HTTP_OK, array('Default','Details'));
    }

    /**
     * @param Application $application
     * @return mixed
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function deleteApplicationAction(Application $application = null)
    {
        if($application == null){
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($application);
        $em->flush();

        return JsonResponse::create(array('status' => 'Removed', 'message' => 'Application properly removed'));
    }
}
