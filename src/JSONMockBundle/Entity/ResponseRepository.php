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
    public function getResponseByRouteAndMethod($route, $method)
    {
        $response = $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.url = :url')
            ->andWhere('r.method = :method')
            ->setParameters(array('url' => $route, 'method' => $method))
            ->getQuery()
            ->getOneOrNullResult();

        return $response;
    }
}
