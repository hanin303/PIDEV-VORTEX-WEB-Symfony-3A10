<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use App\services\imageUploader;
use App\Form\ProfileType;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditController extends AbstractController
{
    #[Route('/edit', name: 'app_edit', methods: ['GET', 'POST'])]
    public function editAdmin(Request $request, AuthenticationUtils $authenticationUtils,UserRepository $userRepository,imageUploader $imageUploader): Response
    {
        $user= new User();
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user= $userRepository->findOneBy(['username'=>$lastUsername]);
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $oldPassword = $form->get('password')->getData();
            $newPassword = $form->get('newPassword')->getData();
            if($oldPassword){
              $this->addFlash('fail', 'Vous devez entrer votre ancien mot de passe');
              return $this->redirectToRoute('app_edit', [], Response::HTTP_SEE_OTHER);
            }else{
                if($oldPassword!=$user->getPassword()){
                    $this->addFlash('fail', 'Votre ancien mot de passe est incorrect');
                    return $this->redirectToRoute('app_edit', [], Response::HTTP_SEE_OTHER);
                }else{
                    $user->setPassword( $userPasswordEncoder->encodePassword(
                        $user,
                        $newPassword
                    ));
                    $userRepository->save($user,true);
                    $this->addFlash('success', 'Votre compte a été modifié avec succès');
                    return $this->redirectToRoute('app_user_index');
                }
    }       
}
$user->setPassword($user->getPassword());
return $this->render('edit/profile.html.twig', [
    'last_username' => $authenticationUtils->getLastUsername(),
    'error' => $authenticationUtils->getLastAuthenticationError(),
    'form' => $form->createView(),
]);

} 
}
