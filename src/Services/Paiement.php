<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class Paiement
{

    /**
     * @var \Symfony\Component\HttpFoundation\Request|null
     */
    private $request;

    public function __construct(RequestStack $requestStack)
    {
         $this->request = $requestStack->getMasterRequest();
    }


    public function doPayment(float  $amount, string $description) {
        // TODO

        $token = $this->request->get('stripeToken');
    }

}