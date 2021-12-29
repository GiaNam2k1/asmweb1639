<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Required;

class StudentController extends AbstractController
{
    private $em;

    public function __construct(PersistenceManagerRegistry $registry)
    {
        $this->em = $registry;
    }

    #[Route('/students', name:'student_index')]
    public function studentIndex() {
        $students = $this->em->getRepository(Student::class)->findAll();
        return $this->render("student/index.html.twig",[
            'students' => $students
        ]);
    }

    #[Route('/student/detail/{id}', name:'student_detail')]
    public function studentDetail($id) {
        $student = $this->em->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash("Error", "Student not found");
            return $this->redirectToRoute('student_index');
        }
        return $this->render('student/detail.html.twig',[
            'student' => $student
        ]);
    }

    #[IsGranted("ROLE_ADMIN"), Route('/student/delete/{id}', name: 'student_delete')]
    public function studentDelete($id) {
        $student = $this->em->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash("Error", "Student delete failed");
            return $this->redirectToRoute('student_delete');
        } else {
            $manager = $this->em->getManager();
            $manager->remove($student);
            $manager->flush();
        }
        return $this->redirectToRoute('student_index');
    }

    #[IsGranted("ROLE_ADMIN"), Route('/student/add', name: 'student_add')]
    public function studentAdd(Request $request) {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->em->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash("Success", "Add student succeed");
            return $this->redirectToRoute('student_index');
        }

        return $this->renderForm("student/add.html.twig",[
            'form' => $form
        ]);
    }
    
    #[IsGranted("ROLE_ADMIN"), Route('/student/edit/{id}', name: 'student_edit')]
    public function studentEdit(Request $request, $id) {
        $student = $this->em->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->em->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash("Success", "Edit student succeed");
            return $this->redirectToRoute('student_index');
        }

        return $this->renderForm("student/edit.html.twig",[
            'form' => $form
        ]);
    } 
}
