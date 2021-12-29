<?php

namespace App\DataFixtures;

use App\Entity\CourseCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $coursecategory = new CourseCategory();
            $coursecategory->setName("Category $i");
            $coursecategory->setDescription("Description");
            $manager->persist($coursecategory);
        }

        $manager->flush();
    }
}
