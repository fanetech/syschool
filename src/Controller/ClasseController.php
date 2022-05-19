<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('classe')]
class ClasseController extends AbstractController
{
    #[Route('/add', name: 'classe.add')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {

        $classe = new Classe();
        $form = $this->createForm(ClasseType::class, $classe);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $doctrine->getManager();
            $manager->persist($classe);

            $manager->flush();
            return $this->redirectToRoute('classe.show.all');
        } else {
            return $this->render('classe/index.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
    #[Route('/show/all', name: 'classe.show.all')]
    public function showAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Classe::class);
        $classe = $repository->findAll();
        return $this->render('classe/show.all.html.twig', ['classes' => $classe]);
    }
    #[Route('/{id}/edit', name: 'classe.edit')]
    public function edit(Classe $classe, ManagerRegistry $doctrine, Request $request): Response
    {
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($classe);

            $manager->flush();
            return $this->redirectToRoute('classe.show.all');
        } else {
            return $this->render('classe/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
    #[Route('/{id}/delele', name: 'classe.delete')]
    public function delete(Classe $classe, ClasseRepository $repository): Response
    {
        $repository->remove($classe, true);

        return $this->redirectToRoute('classe.show.all');
    }
}
