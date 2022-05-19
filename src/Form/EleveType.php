<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EleveType extends AbstractType
{
    private UserRepository $userRepo;
    function __construct(UserRepository $repo)
    {
        $this->userRepo = $repo;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('photo')
            ->add('parent', EntityType::class, [
                "class" => User::class,
                "query_builder" => $this->userRepo->findParentsQb(),
                "choice_label" => "nom"
            ])
            ->add('classe')
            ->add('Enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
