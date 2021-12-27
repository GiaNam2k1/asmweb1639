<?php

namespace App\DataFixtures;

use App\Entity\Classroom;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=5;$i++){
            $classroom = new Classroom;
            $classroom->setCourse("Course $i");
            $classroom->setClassName("GCH080$i");
            $manager->persist($classroom);
        }

        $manager->flush();
    }
}
