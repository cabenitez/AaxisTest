<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use  Symfony\Component\Security\Http\Event\InteractiveLoginEvent;


use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

//#[Route('/api/users')]
class UserController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, 
                                private UserPasswordHasherInterface $passwordHasher
                             )
    {
    }

    #[Route('/api/users/create', name: 'user_create', methods:'POST')]
    public function create(Request $request): JsonResponse
    {
        // convert to array for manipulation
        $userData = $request->toArray();

        // check if user was created previusly
        $userRepository = $this->entityManager->getRepository(User::class);
        $existingUser = $userRepository->findOneBy(['email' => $userData['email']]);

        if ($existingUser) {
            return $this->json(['error' => 'The user already exists.'], 400);
        }

        // create a new user
        $user = new User();
        $user->setEmail($userData['email']);

        // set password
        $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        // register object
        $this->entityManager->persist($user);

        // persist changes
        $this->entityManager->flush();

        // response
        return $this->json(['message' => 'User created.']);      
    }


    #[Route('/api/login', name: 'login_check' , methods:'POST')]
    public function login(Request $request): JsonResponse
    {
        
        //try {
        
            // convert to array for manipulation
            $userData = $request->toArray();

            // find user
            $userRepository = $this->entityManager->getRepository(User::class);
            $user = $userRepository->findOneBy(['email' => $userData['email']]);

            // generate the token
            //$token = $this->JWTManager->create($user);


            // response
            return $this->json(['token' => '$token']);

            
            //$jwt = $this->container->get('lexik_jwt_authentication.jwt_manager')->create($user);
            //$authenticationSuccessHandler = $this->container->get('lexik_jwt_authentication.handler.authentication_success');
            //return $authenticationSuccessHandler->handleAuthenticationSuccess($user, $jwt);
            //return $authenticationSuccessHandler->handleAuthenticationSuccess($user);
            
        //} catch (\Exception $e) {
            
            //return new JsonResponse(['error' => 'Error creating token'], 500);
        //}

    }


}
