<?php

namespace App\Validator;

use App\Repository\BookingRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class NotTuesdayValidator extends ConstraintValidator
{
//    /**
//     * @var BookingRepository
//     */
//    private $bookingRepository;
//
//    /**
//     * NotTuesdayValidator constructor.
//     * @param BookingRepository $bookingRepository
//     */
//    public function __construct(BookingRepository $bookingRepository)
//    {
//        $this->bookingRepository = $bookingRepository;
//    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\NotTuesday */

        if (!$value instanceof \DateTimeInterface) {
            throw new ConstraintDefinitionException();
        }

        if($value->format('w') === "2"){
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
