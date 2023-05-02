<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Repository\TrajetRepository;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        return $this->render('Front/front.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/tarifs', name: 'tarif_ticket')]
    public function listTarifs(): Response
    {
        return $this->render('ticket/tarif.html.twig');
    }

    #[Route('/lignes', name: 'lignes_urbaine')]
    public function listLignes(): Response
    {
        return $this->render('moyentransport/ligne.html.twig');
    }

    #[Route('/trajets', name: 'voyager_trajet', methods: ['GET'])]
    public function listTrajet(TrajetRepository $trajetRepository): Response
    {
        return $this->render('trajet/trajetFront.html.twig', [
            'trajets' => $trajetRepository->findAll(),
        ]);
    }

    #[Route('/communes', name: 'voyager_commune')]
    public function listCommunes(): Response
    {
        return $this->render('commune/commune.html.twig');
    }

    #[Route('/reclamation', name: 'reclamation')]
    public function listReclamations(): Response
    {
        return $this->render('reclamation/reclamation.html.twig');
    }
}
