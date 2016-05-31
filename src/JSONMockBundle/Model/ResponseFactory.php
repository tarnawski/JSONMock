<?php

namespace JSONMockBundle\Model;

use Doctrine\ORM\EntityRepository;
use JSONMockBundle\Entity\Application;
use JSONMockBundle\Entity\Response;

class ResponseFactory
{
    /**
     * @var EntityRepository
     */
    private $userRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->userRepository = $entityRepository;
    }

    public function createFirst(Application $application)
    {
        $value = array("Message" => "Hello world!!!");

        $response = new Response();
        $response->setName("Hello world");
        $response->setUrl("welcome");
        $response->setMethod("GET");
        $response->setStatusCode(200);
        $response->setValue($value);
        $response->setApplication($application);

        return $response;
    }
}
