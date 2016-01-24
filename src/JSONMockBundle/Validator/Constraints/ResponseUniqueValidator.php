<?php

namespace JSONMockBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use JSONMockBundle\Entity\Response;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ResponseUniqueValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($protocol, Constraint $constraint)
    {
        if ($this->isUnique($constraint, $protocol) == false) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function isUnique(Constraint $constraint, $protocol)
    {
        $responseRepository = $this->entityManager->getRepository(Response::class);
        $response = $responseRepository->findBy(array(
            'url' => $protocol->getUrl(),
            'method' => $protocol->getMethod()
        ));
        if (empty($response)) {
            return true;
        } else {
            if($response[0]->getId() == $protocol->getId()){
                return true;
            }else{
                return false;
            }
        }
    }
}