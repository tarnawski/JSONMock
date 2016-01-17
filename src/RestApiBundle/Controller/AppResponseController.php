<?php

namespace RestApiBundle\Controller;

use JSONMockBundle\Entity\ResponseRepository;
use RestApiBundle\Form\Type\ApplicationEditType;
use RestApiBundle\Form\Type\ApplicationType;
use JSONMockBundle\Entity\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RestApiBundle\Controller\ApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class AppResponseController
 */
class AppResponseController extends ApiController
{
    public function getEntityClassName()
    {
        return 'JSONMockBundle\Entity\Response';
    }

    /**
     * @param $route
     * @param Application $application
     * @return mixed
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function getResponseAction(
        $route,
        Application $application = null
    ) {
        if ($application == null) {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'));
        }

        $method = $this->get('request')->getMethod();

        $responseRepository = $this->getRepository($this->getEntityClassName());
        $response = $responseRepository->getResponseByRouteAndMethod($route, $method);

        if ($response != null) {
            return $this->success($response, 'response', Response::HTTP_OK, array('Default','Details'));
        } else {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'Request not found'));
        }
    }
}
