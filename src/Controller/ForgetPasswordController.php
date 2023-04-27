<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\ByteString;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\services\Mailer;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;





class ForgetPasswordController extends AbstractController
{
    private int $code;
    private $user;
    #[Route('/forget', name: 'app_security_forget1')]
    public function index(Request $request, UserRepository $userRepository,MailerInterface $mailerInterface,UrlGeneratorInterface $urlGenerator): Response
    {
        $email = $request->request->get('email');
        $user=$userRepository->findOneBy(['email'=>$email]);
        if($user!=null){
            $mail= new Mailer($mailerInterface);
            $cd=$this->generateCode();
            $mail->sendEmail($user->getEmail(),$cd);
            $this->user=$user;
            return $this->redirectToRoute('app_security_forget2');
        }
        return $this->redirectToRoute('app_security_forget2');
    }
    public function generateCode(){
        $bytes = random_bytes(6);
        $code = bin2hex($bytes);
        return $code;
    }
    public function verifyCode(string $user_code){
        if(strcmp($this->code,$user_code)==0){
            return true;
        }else{
            return false;
        }
    }
   #[Route('/email', name: 'app_security_forget2')]
    public function verify(Request $request, UserRepository $userRepository,MailerInterface $mailerInterface,UrlGeneratorInterface $urlGenerator)
    {
        $codeInput = $request->request->get('code');
        if($this->verifyCode($codeInput)){
            return $this->redirectToRoute('app_security_change');
            $this->addFlash('success', 'Votre code est correct');
        }else{
            $this->addFlash('success', 'Votre code est invalide'); 
            return $this->redirectToRoute('app_security_login');
        }
        return $this->redirectToRoute('app_security_change');

    }
    #[Route('/code', name: 'app_security_change')]
    public function changePassword(Request $request,UserPasswordEncoderInterface $userPasswordEncoder,EntityManagerInterface $entityManager)
    {
        $newPassword = $request->request->get('code');
        $this->user->setPassword($userPasswordEncoder->encodePassword($this->user,$newPassword));
        $entityManager->flush();
        $this->addFlash('success', 'Votre mot de passe a été modifié avec succès.');
        return $this->redirectToRoute('security_login');
    }
   
}
