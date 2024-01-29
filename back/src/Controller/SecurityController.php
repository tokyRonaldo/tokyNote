<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NoteBlocRepository;
use App\Repository\UserRepository;
use App\Entity\NoteBloc;
use App\Entity\User;
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;


    /**
     * @Route("/api/login", name="app_login")
     */

class SecurityController extends AbstractController
{
    public function login(){
        $user=$this->getUser();
        return $this->json([
            "username"=>$user->getUsername(),
            "roles"=>$user->getRoles()
        ]);
    }
}