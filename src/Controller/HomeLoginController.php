<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


namespace App\Controller;

use App\Repository\TicketRepository;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommuneRepository;
use App\Form\CommuneType;
use App\Entity\Commune;

class HomeLoginController extends AbstractController
{
    #[Route('/login', name: 'app_home_login')]
    public function index(): Response
    {
        return $this->render('Front/login.html.twig', [
            'controller_name' => 'HomeLoginController',
        ]);
    }
    
    #[Route('/register', name: 'Inscription')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig');
    }

    

}
