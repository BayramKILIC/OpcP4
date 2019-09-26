<?php


namespace App\Tests\Services;


use App\Entity\Booking;
use App\Entity\Ticket;
use App\Services\PriceCalculator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{

    public function ($expectedPrice)
    {
        $priceCalculator = new PriceCalculator();

        $ticket = new Ticket();
        // ...

        $booking = new Booking();
        $booking->setVisitDate(new \DateTime('2000-01-01'));

        // ...

        $booking->addTicket($ticket);

        $this->assertEquals($expectedPrice, $priceCalculator->computeTicketPrice($ticket));



    }


    /**
     *   [$dateDeNaissance, $reduction, $bookingType, $expectedPrice]
     * @return \Generator
     */
    public function dataProvider()
    {
        yield [new \DateTime('1980-01-01'), false, Booking::TYPE_DAY, 16];

    }
}