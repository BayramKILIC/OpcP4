<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotFullDayAfter14h extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Vous ne pouvez pas commander de billet "journée" après 14h';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
