<?php


namespace App\Services;


use App\Entity\Booking;

class PriceCalculator
{

    const ONE_DAY_NORMAL = 16;  // price list
    const ONE_DAY_CHILD = 8;
    const ONE_DAY_SENIOR = 12;
    const ONE_DAY_DISCOUNT = 10;
    const ONE_DAY_BABY = 10;
    const HALF_DAY_COEFF = 0.5;

    const AGE_CHILD = 4;
    const AGE_NORMAL = 12;
    const AGE_SENIOR = 60;

    public function computePrice(Booking $booking)
    {
        // TODO calcul du prix
    }

}