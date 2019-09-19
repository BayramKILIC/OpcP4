<?php


namespace App\Manager;

use App\Entity\Booking;
use App\Entity\Ticket;
use App\Services\EmailService;
use App\Services\Paiement;
use Doctrine\ORM\EntityManagerInterface;
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
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var EmailService
     */
    private $emailService;


    public function __construct(SessionInterface $session, Paiement $payment, EntityManagerInterface $em, EmailService $emailService)
    {
        $this->session = $session;
        $this->payment = $payment;
        $this->em = $em;
        $this->emailService = $emailService;
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

        $booking = $this->session->get(self::SESSION_ID);

        if (!$booking instanceof Booking) {
            throw  new NotFoundHttpException();
        }
        return $booking;
    }

    public function removeCurrentBooking()
    {

        $this->session->remove(self::SESSION_ID);

    }

    public function doPayment(Booking $booking)
    {
        // TODO mettre la description
        $reference = $this->payment->doPayment($booking->getTotalPrice(), "TODO");
        if ($reference) {
            $booking->setOrderCode($reference['id']);
            $booking->setOrderDate(new \DateTime());
            $this->em->persist($booking);
            $this->em->flush();
            $this->emailService->sendMail($booking);
            return true;
        };
        return false;
    }

}