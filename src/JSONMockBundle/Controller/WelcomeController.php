<?php

namespace JSONMockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class WelcomeController
 */
class WelcomeController extends Controller
{
    public function welcomeAction()
    {
        return $this->render('default/index.html.twig');
    }
}
