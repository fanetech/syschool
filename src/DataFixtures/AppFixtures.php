<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= 100; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword('$2y$13$rhplmdumhA2TxFXqEUznvuH12rhTyr8/qYu9RZilPtgCWaFTmMqOW');
            if ($i % 2 == 0) $user->setRoles(['USER_ECOLE']);
            else  $user->setRoles(['USER_PARENT']);
            $manager->persist($user);
        }


        $manager->flush();
    }
}
