<?php

namespace spec\JSONMockBundle\Model;

use Doctrine\ORM\EntityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApplicationFactorySpec extends ObjectBehavior
{
    function let(EntityRepository $entityRepository)
    {
        $this->beConstructedWith($entityRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('JSONMockBundle\Model\ApplicationFactory');
    }

    function it_should_create()
    {
        $this->create('name')->shouldReturnAnInstanceOf('JSONMockBundle\Entity\Application');
    }
}
