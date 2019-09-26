<?php

namespace App\Controller;

use App\Form\FormStepOneType;
use App\Form\ShowTicketType;
use App\Manager\BookingManager;
use App\Services\PriceCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function orderTicket(Request $request, BookingManager $bookingManager)
    {
        $booking = $bookingManager->initNewBooking();

        $form = $this->createForm(FormStepOneType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingManager->generateEmptyTickets($booking);
            return $this->redirectToRoute('order_name');
        }

        return $this->render('ticket/ticket.html.twig', [
            'formStepOne' => $form->createView()
        ]);
    }

    /**
     * @Route("/identification", name="order_name")
     */
    public function orderName(Request $request, BookingManager $bookingManager, PriceCalculator $calculator)
    {
        $booking = $bookingManager->getCurrentBooking(['init']);
        $form = $this->createForm(ShowTicketType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calculator->computeTotalPrice($booking);
            return $this->redirect($this->generateUrl('order_recap'));
        }

        return $this->render('ticket/identification.html.twig', [
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/recap", name="order_recap")
     * @param BookingManager $bookingManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function orderRecap(BookingManager $bookingManager, Request $request)
    {

        $booking = $bookingManager->getCurrentBooking(['fillTickets','priceComputed']);
        if ($request->isMethod('POST')) {

            if ($bookingManager->doPayment($booking)) {
                return $this->redirect($this->generateUrl('order_confirmation'));

            } else {

                $this->addFlash(
                    'danger',
                    'Un problème de paiement a été rencontré, merci de réessayer'
                );
            }
        }

        return $this->render('ticket/recap.html.twig', [
            'booking' => $booking
        ]);
    }

    /**
     * @Route("/confirmation", name="order_confirmation")
     */
    public function confirmation(BookingManager $bookingManager)
    {
        $booking = $bookingManager->getCurrentBooking(['completed']);
        // TODO $bookingManager->removeCurrentBooking();


        return $this->render('ticket/confirmation.html.twig', [
            'booking' => $booking
        ]);
    }

}
