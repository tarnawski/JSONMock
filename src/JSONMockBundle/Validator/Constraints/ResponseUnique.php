<?php

namespace JSONMockBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ResponseUnique extends Constraint
{
    public $message = 'Response exist';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return 'response_validate';
    }
}
