<?php
namespace App\services;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
class Mailer
{
    /**
     * @var MailerInterface
    */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }
    public function sendEmail(string $reciver)
    {
        $email = (new Email())
        ->from(Address::create('Fabien Potencier <swiftTransit12@hotmail.com>'))
        ->to('riad.amami@gmail.com')
        ->subject('Experimenting with Symfony Mailer and Mailtrap')
        ->text('Hey! Learn the best practices ');
        // path to your Twig template
        $this->mailer->send($email);

    }
}