<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/eleve')]
class EleveController extends AbstractController
{
    #[Route('/add', name: 'eleve.add')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $eleve = new Eleve();
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $doctrine->getManager();
            $manager->persist($eleve);
            $manager->flush();
            return $this->redirectToRoute('eleve.show.all');
        } else {

            return $this->render('eleve/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
    #[Route('/show/all', name: 'eleve.show.all')]
    public function showAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Eleve::class);
        $eleve = $repository->findAll();
        return $this->render('eleve/show.all.html.twig', [
            'eleves' => $eleve
        ]);
    }
}
