<?php

namespace App\Validator;

use App\Repository\BookingRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class NotSundayValidator extends ConstraintValidator
{


    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\NotSunday */

        if (!$value instanceof \DateTimeInterface) {
            throw new ConstraintDefinitionException();
        }

        if($value->format('w') === "0"){
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
