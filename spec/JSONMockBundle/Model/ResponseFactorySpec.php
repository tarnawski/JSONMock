<?php

namespace spec\JSONMockBundle\Model;

use Doctrine\ORM\EntityRepository;
use JSONMockBundle\Entity\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseFactorySpec extends ObjectBehavior
{
    function let(EntityRepository $entityRepository)
    {
        $this->beConstructedWith($entityRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('JSONMockBundle\Model\ResponseFactory');
    }

    function it_should_return_welcome_response(Application $application)
    {
        $result = $this->createFirst($application);

        $result->shouldReturnAnInstanceOf('JSONMockBundle\Entity\Response');
        $result->getName()->shouldReturn("Hello world");
    }
}
