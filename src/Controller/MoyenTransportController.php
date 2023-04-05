<?php

namespace App\Controller;

use App\Entity\MoyenTransport;
use App\Form\MoyenTransportType;
use App\Repository\MoyenTransportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/moyen/transport')]
class MoyenTransportController extends AbstractController
{
    #[Route('/', name: 'app_moyen_transport_index', methods: ['GET'])]
    public function index(MoyenTransportRepository $moyenTransportRepository): Response
    {
        return $this->render('moyen_transport/index.html.twig', [
            'moyen_transports' => $moyenTransportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_moyen_transport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MoyenTransportRepository $moyenTransportRepository): Response
    {
        $moyenTransport = new MoyenTransport();
        $form = $this->createForm(MoyenTransportType::class, $moyenTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moyenTransportRepository->save($moyenTransport, true);

            return $this->redirectToRoute('app_moyen_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moyen_transport/new.html.twig', [
            'moyen_transport' => $moyenTransport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_moyen_transport_show', methods: ['GET'])]
    public function show(MoyenTransport $moyenTransport): Response
    {
        return $this->render('moyen_transport/show.html.twig', [
            'moyen_transport' => $moyenTransport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_moyen_transport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MoyenTransport $moyenTransport, MoyenTransportRepository $moyenTransportRepository): Response
    {
        $form = $this->createForm(MoyenTransportType::class, $moyenTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moyenTransportRepository->save($moyenTransport, true);

            return $this->redirectToRoute('app_moyen_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moyen_transport/edit.html.twig', [
            'moyen_transport' => $moyenTransport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_moyen_transport_delete', methods: ['POST'])]
    public function delete(Request $request, MoyenTransport $moyenTransport, MoyenTransportRepository $moyenTransportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moyenTransport->getId(), $request->request->get('_token'))) {
            $moyenTransportRepository->remove($moyenTransport, true);
        }

        return $this->redirectToRoute('app_moyen_transport_index', [], Response::HTTP_SEE_OTHER);
    }
}
