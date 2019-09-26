<?php


namespace App\Tests\Services;


use App\Entity\Booking;
use App\Entity\Ticket;
use App\Services\PriceCalculator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @param $dateDeNaissance
     * @param $reduction
     * @param $bookingType
     * @param $expectedPrice
     * @throws \Exception
     */
    public function testPriceComputing ($dateDeNaissance,$reduction,$bookingType,$expectedPrice)
    {
        $priceCalculator = new PriceCalculator();

        $ticket = new Ticket();
        $ticket->setBirthdate($dateDeNaissance);
        $ticket->setReduction($reduction);



        $booking = new Booking();
        $booking->setVisitDate(new \DateTime('2000-01-01'));
        $booking->setTicketNumber('1');
        $booking->setVisitType($bookingType);

        $booking->addTicket($ticket);

        $this->assertEquals($expectedPrice, $priceCalculator->computeTicketPrice($ticket));


    }

    /**
     *   [$dateDeNaissance, $reduction, $bookingType, $expectedPrice]
     * @return \Generator
     */
    public function dataProvider()
    {
        // 20 ans - tarif normal
        yield [new \DateTime('1980-01-01'), false, Booking::TYPE_DAY, 16];
        yield [new \DateTime('1980-01-01'), false, Booking::TYPE_HALF_DAY, 8];
        yield [new \DateTime('1980-01-01'), true, Booking::TYPE_DAY, 10];
        yield [new \DateTime('1980-01-01'), true, Booking::TYPE_HALF_DAY, 5];

        // 2 ans - gratuit
        yield [new \DateTime('1998-01-01'), false, Booking::TYPE_DAY, 0];
        yield [new \DateTime('1998-01-01'), false, Booking::TYPE_HALF_DAY, 0];
        yield [new \DateTime('1998-01-01'), true, Booking::TYPE_DAY, 0];
        yield [new \DateTime('1998-01-01'), true, Booking::TYPE_HALF_DAY, 0];

        // 10 ans - tarif enfant
        yield [new \DateTime('1990-01-01'), false, Booking::TYPE_DAY, 8];
        yield [new \DateTime('1990-01-01'), false, Booking::TYPE_HALF_DAY, 4];
        yield [new \DateTime('1990-01-01'), true, Booking::TYPE_DAY, 8];
        yield [new \DateTime('1990-01-01'), true, Booking::TYPE_HALF_DAY, 4];

        // 80 ans - tarif senior
        yield [new \DateTime('1920-01-01'), false, Booking::TYPE_DAY, 12];
        yield [new \DateTime('1920-01-01'), false, Booking::TYPE_HALF_DAY, 6];
        yield [new \DateTime('1920-01-01'), true, Booking::TYPE_DAY, 10];
        yield [new \DateTime('1920-01-01'), true, Booking::TYPE_HALF_DAY, 5];

    }
}