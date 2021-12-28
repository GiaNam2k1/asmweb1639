<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=5; $i++){
            $student = new Student;
            $student->setName("Student $i");
            $student->setBirthday(\DateTime::createFromFormat('Y-m-d', '2000-10-20'));
            $student->setPhone("0123456778");
            $manager->persist($student);
        }

        $manager->flush();
    }
}
