<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ThousandTicketsReached extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Le nombre de billet maximum (1000) a été atteint';

    public function getTargets()
        {
            return self::CLASS_CONSTRAINT;
        }
}
