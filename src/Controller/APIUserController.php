<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\UserStateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api', name: 'apiUser')]
class APIUserController extends AbstractController
{
    #[Route('/show', name: 'api_get_us', methods: ['GET','POST'])]
    public function show(Request $request,UserRepository $userRepository): JsonResponse
    {
       $user=$userRepository->findOneBy(['id'=> $request->get('id')]);
        if($user!=null){
            return $this->json( ['users' => $user->serializer()]);
        }
        return $this->json(['test'=>$request->get('id')]);
    }
    #[Route('/showAll', name: 'api_get_all', methods: ['GET','POST'])]
    public function showAll(UserRepository $userRepository): JsonResponse
   {
       $encoders = [ new JsonEncoder()];
       $normalizers = [new ObjectNormalizer()];

       $serializer = new Serializer($normalizers, $encoders);
      $users = $userRepository->findAll();
      $serializedUsers = [];
      foreach ($users as $user) {
       $serializedUsers[] = $user->serializer();
      }
     return $this->json($serializedUsers);
    }

    #[Route('/edit', name: 'api_edit', methods: ['GET','POST'])]
    public function edit(Request $request, UserRepository $userRepository)
    {
        $user= $userRepository->findOneBy(['id'=>$request->get('id')]);
            if($request->get('nom')!=null){
                $user->setNom($request->get('nom'));
            }
            if($request->get('prenom')!=null){
                $user->setPrenom($request->get('prenom'));
            }
            if($request->get('username')!=null) {
                $user->setUsername($request->get('username'));
            }
            if($request->get('email')!=null) {
                $user->setEmail($request->get('email'));
            }
            if($request->get('num_tel')!=null) {
                $user->setNumTel((int)$request->get('num_tel'));
            }
            if($request->get('cin')!=null) {
                $user->setCIN((int)$request->get('cin'));
            }
            $userRepository->save($user,true);

            return $this->json(['response'=> 'success']);
    }

    #[Route('/delete', name: 'api_delete', methods: ['GET','POST'])]
    public function delete(Request $request, UserRepository $userRepository)
    {

            $user= $userRepository->findOneBy(['id'=>$request->get('id')]);
            if($user!=null){
                $userRepository->remove($user, true);
                return $this->json(['response'=> 'success']);
            }
            else
                return $this->json(['response'=> 'failed']);
    }
    #[Route('/add', name: 'api_add', methods: ['GET','POST'])]
    public function create(UserPasswordEncoderInterface $userPasswordEncoder ,Request $request, UserRepository $userRepository,RoleRepository $roleRepository,UserStateRepository $userStateRepository)
    {
        $user = new User();
        if($request->get('nom')!=null){
            $user->setNom($request->get('nom'));
        }
        if($request->get('prenom')!=null){
            $user->setPrenom($request->get('prenom'));
        }
        if($request->get('username')!=null) {
            $user->setUsername($request->get('username'));
        }
        if($request->get('email')!=null) {
            $user->setEmail($request->get('email'));
        }
        if($request->get('num_tel')!=null) {
            $user->setNumTel((int)$request->get('num_tel'));
        }
        if($request->get('cin')!=null) {
            $user->setCIN((int)$request->get('cin'));
        }
        if($request->get('mdp')!=null) {
            $user->setPassword($userPasswordEncoder->encodePassword(
                $user,
                $request->get('mdp'))
            );
        }

        $user->setIdState($userStateRepository->findOneBy(['id'=>2]));
        $user->setIdRole($roleRepository->findOneBy(['id'=>4]));
        $userRepository->save($user,true);

        return $this->json(['response'=> 'success']);
    }

}
