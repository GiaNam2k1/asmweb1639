<?php

namespace App\Controller;

use App\Entity\Classroom;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
}
