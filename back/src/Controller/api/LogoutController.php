<?php

// src/Controller/LoginController.php
namespace App\Controller\api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LogoutController extends AbstractController
{

    public function logout(TokenStorageInterface $tokenStorage)
    {
        // Effectuez les étapes de déconnexion nécessaires ici
        // Par exemple, supprimez le token JWT du stockage côté serveur

        // Effacez le token JWT côté serveur
        $tokenStorage->setToken(null);

        return new JsonResponse(['message' => 'Déconnexion réussie']);
    }
}
