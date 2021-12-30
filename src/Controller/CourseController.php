<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\Security\Http\RememberMe\PersistentRememberMeHandler;

class CourseController extends AbstractController
{   
    private $em;

    public function __construct(PersistenceManagerRegistry $registry)
    {
        $this->em = $registry;
    }

    #[Route('/courses', name: 'course_index')]
    public function courseIndex() {
        $courses = $this->em->getRepository(Course::class)->findAll();
        return $this->render("course/index.html.twig",[
            'courses' => $courses
        ]);
    }

    #[Route('/course/detail/{id}', name:'course_detail')]
    public function courseDetail($id) {
        $course = $this->em->getRepository(Course::class)->find($id);
        if ($course == null) {
            $this->addFlash("Error", "course not found");
            return $this->redirectToRoute('course_index');
        }
        return $this->render('course/detail.html.twig',[
            'course' => $course
        ]);
    }   
    #[IsGranted("ROLE_ADMIN"), Route('/course/delete/{id}', name: 'course_delete')]
    public function courseDelete($id) {
        $course = $this->em->getRepository(Course::class)->find($id);
        if ($course == null) {
            $this->addFlash("Error", "Course delete failed");
            return $this->redirectToRoute('course_delete');
        } else {
            $manager = $this->em->getManager();
            $manager->remove($course);
            $manager->flush();
        }
        return $this->redirectToRoute('course_index');
    }

    #[IsGranted("ROLE_ADMIN"), Route('/course/add', name: 'course_add')]
    public function courseAdd(Request $request) {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->em->getManager();
            $manager->persist($course);
            $manager->flush();
            $this->addFlash("Success", "Add course succeed");
            return $this->redirectToRoute('course_index');
        }

        return $this->renderForm("course/add.html.twig",[
            'form' => $form
        ]);
    }

    #[IsGranted("ROLE_ADMIN"), Route('/course/edit/{id}', name: 'course_edit')]
    public function courseEdit(Request $request, $id) {
        $course = $this->em->getRepository(Course::class)->find($id);
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->em->getManager();
            $manager->persist($course);
            $manager->flush();
            $this->addFlash("Success", "Edit course succeed");
            return $this->redirectToRoute('course_index');
        }

        return $this->renderForm("course/edit.html.twig",[
            'form' => $form
        ]);
    } 
}
