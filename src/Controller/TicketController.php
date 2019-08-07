<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Ticket;
use App\Form\FormStepOneType;
use App\Form\ShowTicketType;
use App\Services\PriceCalculator;
use AppBundle\Manager\VisitManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('ticket/home.html.twig');
    }

    /**
     * @Route("/ticket", name="order_ticket")
     */
    public function orderTicket(Request $request, SessionInterface $session)
    {
        $order = new Booking();
        $form = $this->createForm(FormStepOneType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            for($i= 1; $i<=$order->getTicketNumber(); $i++)
            {
                $order->addTicket(new Ticket());
            }

            $session->set('currentBooking', $order);


            return $this->redirectToRoute('order_name');

        }
        return $this->render('ticket/ticket.html.twig', [
            'formStepOne' => $form->createView()
        ]);
    }

    /**
     * @Route("/identification", name="order_name")
     */
    public function order_name(Request $request, SessionInterface $session)
    {
        $order = $session->get('currentBooking');
        $form = $this->createForm(ShowTicketType::class, $order);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {


            return $this->redirect($this->generateUrl('order_name'));
        }

        return $this->render('ticket/identification.html.twig', [

        ]);
    }



    public function orderTickets(PriceCalculator $calculator)
    {
        //$calculator->computePrice($booking);
    }
}
