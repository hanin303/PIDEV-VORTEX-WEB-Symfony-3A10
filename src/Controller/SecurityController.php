<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationType;

class SecurityController extends AbstractController
{
    #[Route('/inscription', name: 'security_registration')]
    public function registration(): Response
    {
        return $this->render('security/registration.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route('/connexion', name: 'security_login')]
    public function login() : Response
    {
        return $this->render('security/login.html.twig');
    }

  
}
