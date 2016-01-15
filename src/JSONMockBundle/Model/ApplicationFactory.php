<?php

namespace JSONMockBundle\Model;

use Doctrine\ORM\EntityRepository;
use JSONMockBundle\Entity\Application;

class ApplicationFactory
{
    /**
     * @var EntityRepository
     */
    private $userRepository;

    public function __construct(EntityRepository $entityRepository){
        $this->userRepository = $entityRepository;
    }

    public function create($name)
    {
        $application = new Application();
        $application->setName($name);
        $application->setAppKey($this->uniqueAppKey());

        return $application;
    }

    private function uniqueAppKey()
    {
        do{
            $appKey = str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ");
            $application = $this->userRepository->findBy(array('appKey' => $appKey));
        }while($application);

        return $appKey;
    }
}
