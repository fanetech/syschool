<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditParentType;
use App\Form\ParentPasswordType;
use App\Form\ParentType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('e/parent')]
class EParentController extends AbstractController
{

    #[Route('/add', name: 'parent.add')]
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHash): Response
    {

        $parent = new User();
        $parent->setIsActif(true);
        $parent->setIsParent(true);
        $parent->setRoles(["USER_PARENT"]);
        $form = $this->createForm(ParentType::class, $parent);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordClair = $parent->getPassword();
            $passCrypte = $passwordHash->hashPassword($parent, $passwordClair);
            $parent->setPassword($passCrypte);
            $parent = $form->getData();
            $manager = $doctrine->getManager();
            $manager->persist($parent);

            $manager->flush();
            return $this->redirectToRoute('parent.show.all');
        } else {
            return $this->render('e_parent/index.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/show/all', name: 'parent.show.all')]
    public function showAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class);
        $parents = $repository->findBy(["isParent" => true]);
        return $this->render('e_parent/show.all.html.twig', ['parents' => $parents]);
    }

    #[Route('/{id}/edit', name: 'parent.edit')]
    public function parentEdit(User $parent, UserRepository $doctrine, Request $request): Response
    {
        $form = $this->createForm(EditParentType::class, $parent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->add($parent, true);
            return $this->redirectToRoute('parent.show.all');
        } else {
            return $this->render('e_parent/edit.html.twig', [
                'form' => $form->createView(),

                'parent' => $parent
            ]);
        }
    }
    #[Route('/{id}/edit/password', name: 'parent.edit.password')]
    public function parentEditPassword(User $parent, UserRepository $doctrine, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(ParentPasswordType::class, $parent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mdp = $request->get('parent_password')["mdp"]["first"];
            $mdpCrypte = $hasher->hashPassword($parent, $mdp);
            $parent->setPassword($mdpCrypte);

            $doctrine->add($parent, true);
            return $this->redirectToRoute('parent.show.all');
        } else {
            return $this->render('e_parent/edit.password.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}
