<?php

namespace spec\JSONMockBundle\DataTransformer;

use Faker\Factory;
use Faker\Generator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JSONMockBundle\DataTransformer\ResponseTransformer');
    }

    function it_should_change_response(Generator $generator)
    {
        $response = [
            "id" => 1,
            "name" => "@word@"
        ];
        $response = json_encode($response);


        $result = $this->transform($response);

        $result->shouldBeString();
        $result->shouldMatch('/{"id":1,"name":"\w+"}/');
    }
}
