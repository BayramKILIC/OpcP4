<?php

namespace App\Validator;

use App\Entity\Booking;
use App\Entity\Reservation;
use App\Validator\ThousandTicketsReached;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class ThousandTicketsReachedValidator extends ConstraintValidator
{
    private $em;
    const LOUVRE_MAX_TICKETS = 1000;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($object, Constraint $constraint)
    {
        if (!$constraint instanceof ThousandTicketsReached) {
            throw new ConstraintDefinitionException();
        }

        if (!$object instanceof Booking) {
            throw new ConstraintDefinitionException();
        }

        $visitDate =$object->getVisitDate();
        $total = $this->em->getRepository(Booking::class)->countNbTickets($visitDate);

        if( $total + $object->getTicketNumber() > self::LOUVRE_MAX_TICKETS) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();

        }
    }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that



}
