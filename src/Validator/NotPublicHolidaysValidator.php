<?php

namespace App\Validator;

use App\Entity\Booking;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class NotPublicHolidaysValidator extends ConstraintValidator
{

    public function getPublicHolidays(Booking $booking)
    {

        $year = $booking->getVisitDate()->format('Y');
        $easterDate  = easter_date($year);
        $easterDay   = date('d', $easterDate);
        $easterMonth = date('m', $easterDate);
        $easterYear   = date('Y', $easterDate);

        $publicHolidays = array(

            date('Y-m-d', mktime(0, 0, 0, 1,  1,  $year)),
            date('Y-m-d', mktime(0, 0, 0, 5,  1,  $year)),
            date('Y-m-d', mktime(0, 0, 0, 5,  8,  $year)),
            date('Y-m-d', mktime(0, 0, 0, 7,  14, $year)),
            date('Y-m-d', mktime(0, 0, 0, 8,  15, $year)),
            date('Y-m-d', mktime(0, 0, 0, 11, 1,  $year)),
            date('Y-m-d', mktime(0, 0, 0, 11, 11, $year)),
            date('Y-m-d', mktime(0, 0, 0, 12, 25, $year)),

            date('Y-m-d',mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear)),
            date('Y-m-d',mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear)),
            date('Y-m-d',mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear)),
        );

        sort($publicHolidays);

        if (in_array($booking->getVisitDate()->format('Y-m-d'), $publicHolidays )) {
            return true;
        }

        return false;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\NotPublicHolidays*/

        if (!$value instanceof Booking) {
            throw new ConstraintDefinitionException();
        }

        if ($this->getPublicHolidays($value) == true) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

}
