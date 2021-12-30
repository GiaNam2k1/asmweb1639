<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use App\Entity\Classroom;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        

        for($i=1;$i<=5;$i++){
            $teacher = new Teacher;
            // $teacher->setId("$i");
            $teacher->setName("Teacher $i");
            $teacher->setImage("avatar.jpg");
            $teacher->setDob(\DateTime::createFromFormat('Y-m-d','1992-2-24'));
            $teacher->setEmail("teacher@example.com");
            $teacher->setPhone("123456789");
            $teacher->setCity("HCM");
            $teacher->setAddress("Hn");
            $manager->persist($teacher);
        }

        $manager->flush();
    }
}
