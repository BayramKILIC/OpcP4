<?php


namespace App\Tests\Validator;


use App\Validator\NotSunday;
use App\Validator\NotSundayValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class NotSundayValidatorTest extends ConstraintValidatorTestCase
{


    /**
     * @param $name
     * @dataProvider  getDays
     */
    public function testValidator($day, $countError)
    {
        $constraint = new NotSunday();

        $this->validator->validate(new \DateTime($day), $constraint);


        if ($countError) {
            $this->buildViolation($constraint->message)
                ->assertRaised();
        } else {
            $this->assertNoViolation();
        }
    }

    public function getDays()
    {
        return [
            ['sunday', 1],
            ['monday', 0],
            ['tuesday', 0]
        ];
    }

    protected function createValidator()
    {
        return new NotSundayValidator();
    }
}