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
     * @param $param
     * @param Application $application
     * @return mixed
     * @ParamConverter("application", class="JSONMockBundle\Entity\Application", options={"mapping":{"app_key" = "appKey"}})
     */
    public function getResponseAction(
        $param,
        Application $application = null
    ) {

        var_dump($param);exit;

        if($application == null){
            return JsonResponse::create(array('status' => 'Error', 'message' => 'APP_KEY not match'));
        }
        $url = null;
        if($param1!=null){ $url=$param1; }
        if($param2!=null){ $url=$url.'/'.$param2; }
        if($param3!=null){ $url=$url.'/'.$param3; }

        $responses = $application->getResponses();
        $response = null;

        foreach($responses as $obj){
            if($obj->getUrl() == $url){
                 $response = $obj;
            }
        }
        if($response != null){
            return $this->success($response, 'response', Response::HTTP_OK, array('Default','Details'));
        } else {
            return JsonResponse::create(array('status' => 'Error', 'message' => 'Request not found'));
        }

    }
}
