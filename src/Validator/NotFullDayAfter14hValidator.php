<?php

namespace App\Validator;

use App\Entity\Booking;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class NotFullDayAfter14hValidator extends ConstraintValidator
{

    public function validate($object, Constraint $constraint)
    {

        $hour = date("H");

        if(!$object instanceof Booking)
        {
            throw new ConstraintDefinitionException();
        }

        if ($object->getVisitType() == Booking::TYPE_DAY &&
            $object->getVisitDate()->format('d-m-Y') === date('d-m-Y') &&
            $hour >= "14")

        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
