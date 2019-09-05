<?php


namespace App\Services;

use App\Entity\Booking;


class EmailServiceee {

    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
        {
             $this->mailer = $mailer;
        }

    public function sendMail (Booking $booking)
   {
       $email = $booking->getEmail();


       $message = (new \Swift_Message('Confirmation de votre commande'))
           ->setFrom('admin@opc-bayram.com')
           ->setTo($email)
           ->setBody(
               $this->mailer->renderView(
                   'emails/registration.html.twig',
                   ['booking' => $booking]
               ),
               'text/html'
           );

       $this->mailer->send($message);

   }

}