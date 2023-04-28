<?php

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

class ConducteurController extends AbstractController
{
    #[Route('/home', name: 'homeConducteur')]
    public function index(): Response
    {
        return $this->render('Front/front.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/register', name: 'Inscription')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig');
    }

    #[Route('/reserver', name: 'reserver')]
    public function newReservation(Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setHeureDepart($form->get('heure_depart')->getData());
            $reservation->setHeureArrive($form->get('heure_arrive')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $reservation->setStatus("En attente"); 
            $entityManager->persist($reservation);
            $entityManager->flush();
            $this->addFlash('success', 'reservation ajouter avec succès!');
            $reservation = new Reservation(); // create a new instance
            $form = $this->createForm(ReservationType::class, $reservation); 
        }
        return $this->renderForm('reservation/reserver.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/tarifs', name: 'tarif_ticket')]
    public function showListTickets(TicketRepository $ticketRepository): Response
    {
        $tickets = $ticketRepository->findAll();
        return $this->render('ticket/tarif.html.twig', [
            //index.html.twig
            'tickets' => $tickets,
            'controller_name' => 'HomeController',
        ]);
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
