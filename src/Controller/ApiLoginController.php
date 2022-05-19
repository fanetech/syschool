<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

//class ApiLoginController extends AbstractController
//{
//    #[Route('/api/login', name: 'app_api_login')]
//    public function index(): Response
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/ApiLoginController.php',
//        ]);
//    }
//}

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login_json')]
    public function index(#[CurrentUser] ?User $user): Response
    {
        dd($user);
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = "yes"; // somehow create an API token for $user


        //dd($token);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiLoginController.php',
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
