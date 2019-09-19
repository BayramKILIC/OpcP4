<?php


namespace App\Services;

use App\Entity\Booking;
use Twig\Environment;


class EmailService {

    protected $mailer;
    /**
     * @var Environment
     */
    private $twig;
    private $mailerFrom;

    public function __construct(\Swift_Mailer $mailer, Environment $twig,string $mailerFrom)
        {
             $this->mailer = $mailer;
            $this->twig = $twig;
            $this->mailerFrom = $mailerFrom;
        }

    public function sendMail (Booking $booking)
   {
       $email = $booking->getEmail();


       $message = (new \Swift_Message('Confirmation de votre commande'));
       $link = $message->embed(\Swift_Image::fromPath('images/logo.jpg'));
       $message
           ->setFrom($this->mailerFrom)
           ->setTo($email)
           ->setBody($this->twig->render('emails/registration.html.twig',
                   ['booking' => $booking, 'imgLink' => $link]
           ),'text/html');

       $this->mailer->send($message);

   }

}