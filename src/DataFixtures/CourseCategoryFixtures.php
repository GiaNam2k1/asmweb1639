<?php

namespace App\DataFixtures;

use App\Entity\CourseCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseCategoryCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1; $i<=5; $i++){
            $coursecategory = new CourseCategory;
            $coursecategory->setName("CourseCategory $i");
            $coursecategory->setDescription("Description");
            $manager->persist($coursecategory);
        }
        $manager->flush();
    }
}
