<?php

namespace App\Controller\api;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/api/register", name="user_register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,JWTTokenManagerInterface $jwtTokenManager)
    {
        // return 'hello';
        $data = json_decode($request->getContent(), true);
        // return $data;

        $user = new User();
        $user->setUsername($data['username']);
        // $user->setEmail('email@gmail.com');
        $user->setPassword($passwordEncoder->encodePassword($user, $data['password']));
        $user->setRoles(['ROLE_USER']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        $token = $jwtTokenManager->create($user);

        return $this->json(['token' => $token]);

        // return $this->json(['message' => $data]);
    }
}
