<?php


namespace App\Tests\Services;


use App\Entity\Booking;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{


    /**
     *   [$dateDeNaissance, $reduction, $bookingType, $expectedPrice]
     * @return \Generator
     */
    public function dataProvider()
    {
        yield [new \DateTime('1980-01-01'), false, Booking::TYPE_DAY, 16];

    }
}