<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    //ma hoa mat khau
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    

    public function load(ObjectManager $manager): void
    {
        // User role
        $user = new User();
        $user->setUsername("User");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->hasher->hashPassword($user, "123456"));
        $manager->persist($user);

        // Admin role
        $user = new User();
        $user->setUsername("Admin");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->hasher->hashPassword($user, "123456"));
        $manager->persist($user);

        $manager->flush();
    }
}
