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
     * @return Response
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function getResponseAction(Application $application = null, $name)
    {

    }
}
