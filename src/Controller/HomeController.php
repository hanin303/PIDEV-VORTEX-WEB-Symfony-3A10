<?php

namespace App\Controller;


use App\Entity\MoyenTransport;
use App\Repository\MoyenTransportRepository;
use App\Form\MoyenTransportRatingType;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Repository\TicketRepository;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\Persistence\ManagerRegistry;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Repository\TrajetRepository;
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


     #[Route('/lignes', name: 'lignes_urbaine' , methods: ['GET'])]
    public function listLignes(MoyenTransportRepository $moyenTransportRepository): Response
     {
         return $this->render('moyen_transport/FrontIndex.html.twig', [
            'moyen_transports' => $moyenTransportRepository->findAll(),
        ]);
     }
 

     #[Route('/star/{id}', name: 'star')]
     public function yourAction(Request $request, $id, ManagerRegistry $doctrine)
 {
     if ($request->isXmlHttpRequest()) {
         // handle the AJAX request
         $data = $request->getContent(); // retrieve the data sent by the client-side JavaScript code
         $repository = $doctrine->getRepository(MoyenTransport::class);
         $moys = $repository->find($id);
         
         if ($moys->getNote() == 0) {
             $moys->setNote($data[6]);
         } else {
             $newNote = ($moys->getNote() + $data[6]) / 2;
             if ($newNote < $moys->getNote()) {
                 $newNote = $moys->getNote();
             }
             $moys->setNote($newNote);
         }
         
         $em=$doctrine->getManager();
         $em->persist($moys);
         $em->flush();
         $bl = $repository->find($id);
         $test=$bl->getNote();
         $response = new Response();//nouvelle instance du response pour la renvoyer a la fonction ajax
         $response->setContent(json_encode($test));//encoder les donnes sous forme JSON et les attribuer a la variable response
         $response->headers->set('Content-Type', 'application/json');
         return $response;//envoie du response
     } 
 }

   /*   #[Route('/lignes/{id}/rate', name: 'moyen_transport_rate' )]
     public function rate(Request $request, MoyenTransport $moyenTransport)
     {
       $form = $this->createForm(MoyenTransportRatingType::class,  $moyenTransport);

       $form->handleRequest($request);
   
       if ($form->isSubmitted() && $form->isValid()) {
           $rating = $form->get('note')->getData();
   
           $moyenTransport->setNote(floatval($rating));
   
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($moyenTransport);
           $entityManager->flush();
   
           return $this->redirectToRoute('lignes_urbaine', ['id' => $moyenTransport->getId()]);
       }
   
       return $this->render('moyen_transport/rate.html.twig', [
           'moyen_transport' => $moyenTransport,
           'form' => $form->createView(),
       ]);
     } */

     #[Route('/lignes/{id}', name: 'lignes_show' , methods: ['GET'])]
     public function ligne(MoyenTransport $moyenTransport): Response
      {
          return $this->render('moyen_transport/FrontShow.html.twig', [
             'moyen_transport' => $moyenTransport,
         ]);
      }

      
  
    #[Route('/itineraires', name: 'voyager_itineraire')]
    public function listItineraires(): Response


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

    #[Route('/communes', name: 'voyager_commune', methods: ['GET'])]
    public function listCommunes(CommuneRepository $communeRepository): Response
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
