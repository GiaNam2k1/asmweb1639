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
     * @Route("/teacher/add", name = "teacher_add")
     */
    public function teacherAdd(Request $reqest){
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($reqest);  
        if ($form->isSubmitted() && $form->isValid()) {
        #upload ảnh
        #lấy tên ảnh từ file upload
        $image = $teacher->getImage();
        #đặt tên mới cho file ảnh=>đảm bảo tên ảnh là duy nhất
        $imageName = uniqid();
        #lấy đuôi ảnh  
        $imgExtension = $image->guessExtension();
        #nối tên mới vs đuôi để complete
        $imgName = $imageName.".".$imgExtension;
        #di chuyển ảnh vào thư mục và add vào db
        try {
            $image->move(
                $this->getParameter('image_teacher'),$imgName
                #đường dãn thư mục chứa ảnh ở file config/severice.yaml
            );
        } catch (FileException $e) {
            throwException($e);
        }
        #luu tên ảnh vào đb
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
     * @Route("/teacher/edit/{id}",name = "teacher_edit")
     */
    public function teacherEdit(Request $reqest,$id){
        $teacher = $this->em->getRepository(Teacher::class)->find($id);
        $form = $this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($reqest); 
        
        if ($form->isSubmitted() && $form->isValid()) {
            //code upload và xử lý tên ảnh
            //B1: lấy dữ liệu ảnh từ form
            $file = $form['image']->getData(); 
            //B2: check xem dữ liệu ảnh có null không
            if ($file != null) { //người dùng bấm select file để update ảnh mới
                //B3: lấy tên ảnh từ file upload
                $image = $teacher->getImage();
                #đặt tên mới cho file ảnh=>đảm bảo tên ảnh là duy nhất
                $imageName = uniqid();
                #lấy đuôi ảnh  
                $imgExtension = $image->guessExtension();
                #nối tên mới vs đuôi để complete
                $imgName = $imageName.".".$imgExtension;
                #di chuyển ảnh vào thư mục và add vào db
                try {
                    $image->move(
                        $this->getParameter('image_teacher'),$imgName
                        #đường dãn thư mục chứa ảnh ở file config/severice.yaml
                    );
                } catch (FileException $e) {
                    throwException($e);
                }
                #luu tên ảnh vào đb
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
