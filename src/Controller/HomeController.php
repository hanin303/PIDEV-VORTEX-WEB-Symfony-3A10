<?php

namespace App\Controller;

use App\Entity\MoyenTransport;
use App\Repository\MoyenTransportRepository;
use App\Form\MoyenTransportRatingType;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\Persistence\ManagerRegistry;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



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
    {
        return $this->render('iteneraire/itineraire.html.twig');
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
