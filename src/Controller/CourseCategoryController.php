<?php

namespace App\Controller;

use App\Form\CourseType;
use App\Entity\CourseCategory;
use App\Form\CourseCategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class CourseCategoryController extends AbstractController
{
    private $em;

    public function __construct(PersistenceManagerRegistry $registry)
    {
        $this->em = $registry;
    }

    #[Route('/course_categories', name:'course_category_index')]
    public function coursecategoryIndex() {
        $coursecategories = $this->em->getRepository(CourseCategory::class)->findAll();
        return $this->render("course_category/index.html.twig",[
            'coursecategories' => $coursecategories
        ]);
    }

    #[Route('/course_category/detail/{id}', name:'course_category_detail')]
    public function coursecategoryDetail($id) {
        $coursecategory = $this->em->getRepository(CourseCategory::class)->find($id);
        if ($coursecategory == null) {
            $this->addFlash("Error", "Course Category not found");
            return $this->redirectToRoute('course_category_index');
        }
        return $this->render('course_category/detail.html.twig',[
            'coursecategory' => $coursecategory
        ]);
    }

    #[IsGranted("ROLE_ADMIN"), Route('/course_category/delete/{id}', name: 'course_category_delete')]
    public function coursecategoryDelete($id) {
        $coursecategory = $this->em->getRepository(CourseCategory::class)->find($id);
        if ($coursecategory == null) {
            $this->addFlash("Error", "Course Category delete failed");
            return $this->redirectToRoute('course_category_delete');
        } else {
            $manager = $this->em->getManager();
            $manager->remove($coursecategory);
            $manager->flush();
        }
        return $this->redirectToRoute('course_category_index');
    }

    #[IsGranted("ROLE_ADMIN"), Route('/course_category/add', name: 'course_category_add')]
    public function coursecategoryAdd(Request $request) {
        $coursecategory = new CourseCategory();
        $form = $this->createForm(CourseCategoryType::class, $coursecategory);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->em->getManager();
            $manager->persist($coursecategory);
            $manager->flush();
            $this->addFlash("Success", "Add course category succeed");
            return $this->redirectToRoute('course_category_index');
        }

        return $this->renderForm("course_category/add.html.twig",[
            'form' => $form
        ]);
    }

    #[IsGranted("ROLE_ADMIN"), Route('/course_category/edit/{id}', name: 'course_category_edit')]
    public function coursecategoryEdit(Request $request, $id) {
        $coursecategory = $this->em->getRepository(CourseCategory::class)->find($id);
        $form = $this->createForm(CourseCategoryType::class, $coursecategory);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->em->getManager();
            $manager->persist($coursecategory);
            $manager->flush();
            $this->addFlash("Success", "Edit course category succeed");
            return $this->redirectToRoute('course_category_index');
        }

        return $this->renderForm("course_category/edit.html.twig",[
            'form' => $form
        ]);
    }

}
