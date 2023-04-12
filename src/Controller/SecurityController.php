<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\UserStateRepository;
use App\services\imageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationType;
class SecurityController extends AbstractController
{
   
    #[Route('/inscription', name: 'security_registration',methods: ['GET', 'POST'])]
    public function registration(Request $request, UserRepository $userRepository,RoleRepository $roleRepository,UserStateRepository $userStateRepository,imageUploader $imageUploader): Response
    {
        $user = new User();
        $user->setIdRole($roleRepository->find(4));
        $user->setIdState($userStateRepository->find(2));
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('mdp')->getData();
            $user->setMdp(base64_encode($password));
            $file=$form->get('images')->getData();
            if($file){
            $imageFileName = $imageUploader->upload($file);
            $user->setImage($imageFileName);

            }
            $userRepository->save($user, true);

            return $this->redirectToRoute('security_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('security/registration.html.twig', [
            'controller_name' => 'RegistrationController',
            'user' => $user,
            'form' => $form->createView(),
                ]);
    }

    #[Route('/connexion', name: 'security_login')]
    public function login() : Response
    {
        return $this->render('security/login.html.twig');
    }

  
}
