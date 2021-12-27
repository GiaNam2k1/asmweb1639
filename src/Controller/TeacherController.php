<?php

namespace App\Controller;

use App\Entity\Teacher;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class TeacherController extends AbstractController
{
    private $em;

    public function __construct(PersistenceManagerRegistry $registry)
    {
        $this->em = $registry;
    }
    /**
     * @Route("/teacher/index",name="teacher_index")
     */
    public function teacherIndex(){
        $teachers=$this->em->getRepository(Teacher::class)->findAll();
        return $this->render("teacher/index.html.twig",
        [
            'teachers'=>$teachers
        ]
        );
    }
    /**
     * @Route("/teacher/detail/{id}",name="teacher_detail")
     */
    public function teacherDetail($id){
        $teacher=$this->em->getRepository(Teacher::class)->find($id);
        if($teacher==null){
            $this->addFlash("Error","Book not found");
            return $this->redirect("teacher_index");
        }
        return $this->render("teacher/detail.html.twig",
        [
            'teacher'=>$teacher
        ]
        );
    }
    /**
     * @Route("/teacher/delete/{id}",name="teacher_delete")
     */
    public function teacherDelete($id){
        $teacher = $this->em->getRepository(Teacher::class)->find($id);
        if($teacher==null){
            $this->addFlash("Error","Delete this teacher failed");
        }else{
            $manager = $this->em->getManager();
            $manager->remove($teacher);
            $manager->flush();
            $this->addFlash("Succeed","Delete succeed");
        }
        return $this->redirect("teacher_index");
    }
    /**
     * @Route("/teacher/add", name = "teacher_add")
     */
    public function teacherAdd(Request $reqest){
        return $this->render("teacher/addteacher.html.twig");
    }
    /**
     * @Route("/teacher/edit/{id}",name = "teacher_edit")
     */
    public function teacherEdit(Request $reqest,$id){

    }
}
