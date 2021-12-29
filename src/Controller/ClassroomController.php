<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class ClassroomController extends AbstractController
{
    private $em;

    public function __construct(PersistenceManagerRegistry $registry)
    {
        $this->em = $registry;
    }
    /**
     * @Route("/classrooms", name="classroom_index")
     */
    public function indexClassroom(){
        $classes = $this->em->getRepository(Classroom::class)->findAll();
        return $this->render('classroom/index.html.twig',
        [
            'classes'=>$classes
        ]
        );
    }
    /**
     * @Route("/classroom/detail/{id}", name="classroom_detail")
     */
    public function classroomDetail($id){
        $class = $this->em->getRepository(Classroom::class)->find($id);
        if($class==null){
            $this->addFlash('Failed','Classroom not found');
            return $this->redirect('classroom_index');
        }
        
        return $this->render('classroom/detail.html.twig',
        [
            'class'=>$class
        ]);
    }

    /**
     * @Route("/classroom/delete/{id}", name = "classroom_delete")
     */
    public function classroomDelete($id){
        $class = $this->em->getRepository(Classroom::class)->find($id);
        if($class==null){
            $this->addFlash('Failed','Classroom not found');
        }else{
            $manager=$this->em->getManager();
            $manager->remove($class);
            $manager->flush();
            $this->addFlash('Succeed','Dedele classroom succeed');
        }
        return $this->redirectToRoute("classroom_index");
    }

    /**
     * @Route("/classroom/add",name="classroom_add")
     */
    public function classroomAdd(Request $request){
        $class = new Classroom();
        $form = $this->createForm(ClassroomType::class, $class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->em->getManager();
            $manager->persist($class);
            $manager->flush();
            $this->addFlash("Success","Add classroom succeed !");
            return $this->redirectToRoute("classroom_index");
        }
        return $this->renderForm('classroom/add.html.twig',
        [
            'form'=>$form
        ]);
    }

    /**
     * @Route("/classroom/edit/{id}",name="classroom_edit")
     */
    public function classroomEdit(Request $request,$id){
        $class = $this->em->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(ClassroomType::class, $class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->em->getManager();
            $manager->persist($class);
            $manager->flush();
            $this->addFlash("Success","Edit classroom succeed !");
            return $this->redirectToRoute("classroom_index");
        }
        return $this->renderForm('classroom/edit.html.twig',
        [
            'form'=>$form
        ]);
    }
}
