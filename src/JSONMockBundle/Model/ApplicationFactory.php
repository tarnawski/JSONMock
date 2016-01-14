<?php

namespace JSONMockBundle\Model;

use JSONMockBundle\Entity\Application;

class ApplicationFactory
{

    public function create($name, $description)
    {
        $application = new Application();
        $application->setName($name);
        $application->setSecret(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"));

        return $application;
    }
}
