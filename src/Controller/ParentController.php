<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParentController extends AbstractController
{
    #[Route('/parent', name: 'parent.dashboard')]
    public function index(): Response
    {
        return $this->render('parent/index.html.twig', [
            'controller_name' => 'ParentController',
        ]);
    }
}
