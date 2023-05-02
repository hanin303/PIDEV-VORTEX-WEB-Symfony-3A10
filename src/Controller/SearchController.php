<?php

namespace App\Controller;

use App\Entity\MoyenTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{

    #[Route('/search', name: 'search')]
    public function index(Request $request): JsonResponse
    {
        $query = $request->query->get('q');
        $entityManager = $this->getDoctrine()->getManager();

        $moys = $entityManager->getRepository(MoyenTransport::class)
            ->createQueryBuilder('m')
            ->where('m.id LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();

        if (empty($moys)) {
            return $this->json(['message' => 'Event not found'], 404);
        }

        $responseData = [];
        foreach ($moys as $moy) {
            $responseData[] = [
                'id' => $moy->getId(),
                'matricule' => $moy->getMatricule(),
                'num' => $moy->getNum(),
                'capacite' => $moy->getCapacite(),
                'type_vehicule' => $moy->getTypeVehicule(),
                'marque' => $moy->getMarque(),
                'etat' => $moy->getEtat(),
                'id_ligne' => $moy->getIdLigne(),
                'station' => $moy->getStation(),
            ];
        }

        return $this->json($responseData);

    }



}
