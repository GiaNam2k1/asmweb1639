<?php

namespace App\DataFixtures;

use App\Entity\Club;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClubFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=5; $i++){
            $club = new Club;
            $club->setName("Club $i");
            $club->setYear(rand(2010, 2020));
            $club->setImage("club.jpg");
            $manager->persist($club);
        }

        $manager->flush();
    }
}
