<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) { }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('jonas');
        $user->setPassword($this->hasher->hashPassword($user, 'jonas'));
        $manager->persist($user);

        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->hasher->hashPassword($user, 'admin'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);



        $manager->flush();
    }
}
