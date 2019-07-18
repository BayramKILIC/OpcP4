<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('ticket/home.html.twig', [
        ]);
    }

    /**
     * @Route("/ticket", name="order_ticket")
     */
    public function orderTicket()
    {
        return $this->render('ticket/ticket.html.twig', [
        ]);
    }
}
