<?php

namespace JSONMockBundle\Model;

use Doctrine\ORM\EntityRepository;
use JSONMockBundle\Entity\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ResponseFactory
{
    /**
     * @var EntityRepository
     */
    private $responseRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->responseRepository = $entityRepository;
    }

    public function create($data)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        if (!$this->uniqueResponse(
            $accessor->getValue($data, '[url]'),
            $accessor->getValue($data, '[method]')
        )) {
            return null;
        }
            $response = new Response();
            $response->setName($accessor->getValue($data, '[name]'));
            $response->setUrl($accessor->getValue($data, '[url]'));
            $response->setValue($accessor->getValue($data, '[value]'));
            $response->setMethod($accessor->getValue($data, '[method]'));
            $response->setStatusCode($accessor->getValue($data, '[statusCode]'));

        return $response;
    }

    private function uniqueResponse($url, $method)
    {
        $response = $this->responseRepository->findBy(array(
            'url' => $url,
            'method' => $method
        ));

        if (!$response) {
            return true;
        } else {
            return false;
        }
    }
}
