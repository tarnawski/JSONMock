<?php

namespace JSONMockBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ResponseRepository
 */
class ResponseRepository extends EntityRepository
{
    /*
     * @param string
     * @return Response $response
     */
    public function getResponseByRouteAndMethod($route, $method, $application)
    {
        $response = $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.url = :url')
            ->andWhere('r.method = :method')
            ->andWhere('r.application = :application')
            ->setParameters(array('url' => $route, 'method' => $method, 'application' => $application->getId()))
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();

        return $response;
    }
}
