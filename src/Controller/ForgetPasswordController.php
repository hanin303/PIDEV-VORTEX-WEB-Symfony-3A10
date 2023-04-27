<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForgetPasswordController extends AbstractController
{
    #[Route('/forget', name: 'app_forget_password')]
    public function index(): Response
    {
        return $this->render('forget_password/index.html.twig', [
            'controller_name' => 'ForgetPasswordController',
        ]);
    }
}
