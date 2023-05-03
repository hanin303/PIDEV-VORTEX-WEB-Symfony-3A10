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
use App\Repository\StationRepository;
use App\Form\StationType;
use App\Entity\Station;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
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

    #[Route('/stations', name: 'voyager_station', methods: ['GET'])]
    public function listTrajet(StationRepository $stationRepository): Response
    {
        $stations = $stationRepository->findAll();
    $stationLongAlts = [];
    foreach ($stations as $station) {
        if ($station->getLongAlt()) {
            $stationLongAlts[] = $station->getLongAlt();
        }
    }
    return $this->render('station/stationFront.html.twig', [
        'stationLongAlts' => $stationLongAlts
    ]);
    }

    
    #[Route('/reclamation', name: 'reclamation')]
    public function listReclamations(): Response
    {
        return $this->render('reclamation/reclamation.html.twig');
    }
}
