<?php 
namespace App\services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;

class mailing{
    public function sendEmail(MailerInterface $mailer, ){
        $email = (new Email())
            ->from('swiftTransit12@hotmail.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Récupération de mot passe')
            ->text('Votre code de récupération de mot de passe est :')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        // ...

    }
}