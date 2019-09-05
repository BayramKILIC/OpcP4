<?php


namespace App\Services;


use App\Entity\Booking;
use App\Entity\Ticket;

class PriceCalculator
{

    const ONE_DAY_NORMAL = 16;  // price list
    const ONE_DAY_CHILD = 8;
    const ONE_DAY_SENIOR = 12;
    const ONE_DAY_DISCOUNT = 10;
    const ONE_DAY_BABY = 0;
    const HALF_DAY_COEFF = 0.5;

    const AGE_CHILD = 4;
    const AGE_NORMAL = 12;
    const AGE_SENIOR = 60;

    public function computeTicketPrice(Ticket $ticket)
    {
        $booking = $ticket->getBooking();
        $birthday = $ticket->getBirthdate();
        $visitdate = $ticket->getBooking()->getVisitDate();
        $age = $birthday->diff($visitdate)->y;
        $discount = $ticket->getReduction();

        if ($age < self::AGE_CHILD) {
            if ($booking->getVisitType()== $booking::TYPE_DAY) {
                $price = self::ONE_DAY_BABY;
            }
            if ($booking->getVisitType() == $booking::TYPE_HALF_DAY) {
                $price = self::ONE_DAY_BABY * self::HALF_DAY_COEFF;
            }
        }

        elseif ($age > self::AGE_SENIOR) {
            if ($booking->getVisitType()== $booking::TYPE_DAY) {
                $price = self::ONE_DAY_SENIOR;
            }
            if ($booking->getVisitType() == $booking::TYPE_HALF_DAY) {
                $price = self::ONE_DAY_SENIOR * self::HALF_DAY_COEFF;
            }
        }

        elseif ($age >= self::AGE_CHILD && $age <= self::AGE_NORMAL) {
            if ($booking->getVisitType() == $booking::TYPE_DAY) {
                $price = self::ONE_DAY_CHILD;
            }
            if ($booking->getVisitType() == $booking::TYPE_HALF_DAY) {
                $price = self::ONE_DAY_CHILD * self::HALF_DAY_COEFF;
            }
        }

        elseif ($age > self::AGE_NORMAL and $age < self::AGE_SENIOR) {
            if ($booking->getVisitType()== $booking::TYPE_DAY) {
                $price = self::ONE_DAY_NORMAL;
            }
            if ($booking->getVisitType() == $booking::TYPE_HALF_DAY) {
                $price = self::ONE_DAY_NORMAL * self::HALF_DAY_COEFF;
            }
        }
        $ticket->setPrice($price);
        return $price;

    }

    public function computeTotalPrice(Booking $booking)
    {
        $totalPrice = 0;

        foreach ($booking->getTickets() as $ticket) {
            $priceTicket = $this->computeTicketPrice($ticket);
            $totalPrice += $priceTicket;
        }

        $booking->setTotalPrice($totalPrice);

        return $totalPrice;
    }

}