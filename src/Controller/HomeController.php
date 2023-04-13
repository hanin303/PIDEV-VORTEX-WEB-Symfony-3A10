<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommuneRepository;
use App\Form\CommuneType;
use App\Entity\Commune;

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

    #[Route('/itineraires', name: 'voyager_itineraire')]
    public function listItineraires(): Response
    {
        return $this->render('iteneraire/itineraire.html.twig');
    }

    #[Route('/communes', name: 'voyager_commune', methods: ['GET'])]
    public function listTrajet(CommuneRepository $communeRepository): Response
    {
        return $this->render('commune/communeFront.html.twig', [
            'communes' => $communeRepository->findAll(),
        ]);
    }
    #[Route('/reclamation', name: 'reclamation')]
    public function listReclamations(): Response
    {
        return $this->render('reclamation/reclamation.html.twig');
    }
}
