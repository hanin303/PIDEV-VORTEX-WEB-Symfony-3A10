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
use App\Entity\User;
use App\Repository\UserRepository;
use App\services\imageUploader;
use App\Form\ClientType;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ConducteurController extends AbstractController
{
    #[Route('/home', name: 'homeConducteur')]
    public function index(): Response
    {
        return $this->render('Front/front.html.twig', [
            'controller_name' => 'ConducteurController',
        ]);
    }
    #[Route('/register', name: 'Inscription')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig');
    }
    public function editUser(Request $request, AuthenticationUtils $authenticationUtils,UserRepository $userRepository,imageUploader $imageUploader): Response
{
    $user= new User();
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();
    $user= $userRepository->findOneBy(['username'=>$lastUsername]);
    $form = $this->createForm(ClientType::class, $user);
    $form->handleRequest($request);
    $pass=$form->get('password')->getData();
    if ($form->isSubmitted() && $form->isValid()){
        if(!$pass){
          $this->addFlash('fail', 'Vous devez entrer votre ancien mot de passe');
          return $this->redirectToRoute('app_Front_profile', [], Response::HTTP_SEE_OTHER);
        }else{
            if($pass==$user->getPassword()){
                $user->setPassword($form->get('newPassword')->getData());
                $userRepository->save($user, true);
                $this->addFlash('success', 'Votre compte a été modifié avec succés');
                return $this->redirectToRoute('app_Front_profile', [], Response::HTTP_SEE_OTHER);
            }else{
                $this->addFlash('fail', 'Votre ancien mot de passe est incorrect');
                return $this->redirectToRoute('app_Front_profile', [], Response::HTTP_SEE_OTHER);
            }    
    }


}        return $this->renderForm('Front/profile.html.twig', [
    'last_username' => $lastUsername, 
    'error' => $error,
    'form' => $form
]);
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
            'controller_name' => 'ConducteurController',
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
