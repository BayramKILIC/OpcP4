<?php


namespace App\Services;


use Stripe\Error\Card;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class Paiement
{

    /**
     * @var \Symfony\Component\HttpFoundation\Request|null
     */
    private $request;

    public function __construct($privateKey,RequestStack $requestStack)
    {
         $this->request = $requestStack->getMasterRequest();
         \Stripe\Stripe::setApiKey($privateKey);
    }


    public function doPayment(float  $amount, string $description) {

        $token = $this->request->get('stripeToken');

        try{
            $charge = \Stripe\Charge::create(array(
                "amount" => $amount * 100,
                "currency" => "eur",
                "source" => $token,
                "description" => $description
            ));
        }catch (Card $exception){
            return false;
        }

        return $charge;

    }

}