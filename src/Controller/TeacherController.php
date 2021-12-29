<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use function PHPUnit\Framework\throwException;

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
     * @IsGranted("ROLE_ADMIN")
     * @Route("/teacher/delete/{id}",name="teacher_delete")
     */
    public function teacherDelete($id){
        $teacher = $this->em->getRepository(Teacher::class)->find($id);
        if ($teacher == null) {
            $this->addFlash("Error","Delete this teacher failed");
        } else {
            $manager = $this->em->getManager();
            $manager->remove($teacher);
            $manager->flush();
            $this->addFlash("Success","Delete succeed");
        }
        return $this->redirectToRoute("teacher_index");

    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/teacher/add", name = "teacher_add")
     */
    public function teacherAdd(Request $reqest){
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($reqest);  
        if ($form->isSubmitted() && $form->isValid()) {
        $image = $teacher->getImage();
        $imageName = uniqid();
        $imgExtension = $image->guessExtension();
        $imgName = $imageName.".".$imgExtension;
        try {
            $image->move(
                $this->getParameter('image_teacher'),$imgName
            );
        } catch (FileException $e) {
            throwException($e);
        }
        $teacher->setImage($imgName);

            $manager = $this->em->getManager();
            $manager->persist($teacher);
            $manager->flush();
            $this->addFlash("Success","Add teacher succeed !");
            return $this->redirectToRoute("teacher_index");
        }

        return $this->renderForm("teacher/add.html.twig",
        [
            'form' => $form
        ]);  
    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/teacher/edit/{id}",name = "teacher_edit")
     */
    public function teacherEdit(Request $reqest,$id){
        $teacher = $this->em->getRepository(Teacher::class)->find($id);
        $form = $this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($reqest); 
        
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData(); 
            if ($file != null) {
                $image = $teacher->getImage();
                $imageName = uniqid();
                $imgExtension = $image->guessExtension();
                $imgName = $imageName.".".$imgExtension;
                try {
                    $image->move(
                        $this->getParameter('image_teacher'),$imgName
                    );
                } catch (FileException $e) {
                    throwException($e);
                }
                $teacher->setImage($imgName);
            }

            $manager = $this->em->getManager();
            $manager->persist($teacher);
            $manager->flush();
            $this->addFlash("Success","Edit teacher succeed !");
            return $this->redirectToRoute("teacher_index");
        }

        return $this->renderForm("teacher/edit.html.twig",
        [
            'form' => $form
        ]);
    }
}
