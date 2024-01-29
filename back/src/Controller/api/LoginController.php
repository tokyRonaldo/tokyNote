<?php

// src/Controller/LoginController.php
namespace App\Controller\api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


class LoginController extends AbstractController
{
    /**
     * @Route("/api/login", name="app_login", methods={"POST"})
     */
    public function login(Security $security,JWTTokenManagerInterface $jwtTokenManager)
    {
        /** @var UserInterface $user */
        $user = $security->getUser();
        $token = $jwtTokenManager->create($user);

        return $this->json([
            'username' => $user->getUsername(),
            'id' => $user->getid(),
            'token' => $token,
        ]);
    }
}
