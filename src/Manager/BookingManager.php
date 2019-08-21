<?php


namespace App\Manager;

use App\Entity\Booking;
use App\Entity\Ticket;
use App\Services\Paiement;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingManager
{
    const SESSION_ID = 'current_booking';

    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var Paiement
     */
    private $payment;


    public function __construct(SessionInterface $session, Paiement $payment)
    {
        $this->session = $session;
        $this->payment = $payment;
    }

    public function initNewBooking()
    {
        $booking = new Booking();

        $this->session->set(self::SESSION_ID, $booking);

        return $booking;

    }

    public function generateEmptyTickets(Booking $booking)
    {

        for ($i = 1; $i <= $booking->getTicketNumber(); $i++) {
            $booking->addTicket(new Ticket());
        }
    }

    public function getCurrentBooking()
    {

        $booking =  $this->session->get(self::SESSION_ID);

        if(!$booking instanceof  Booking){
            throw  new NotFoundHttpException();
        }


        return $booking;
    }

    public function doPayment(Booking $booking)
    {
        $reference = $this->payment->doPayment($booking -> getTotalPrice(), "xxx");
        if($reference){
            $booking->setOrderCode($reference['id']);

        };
    }

}