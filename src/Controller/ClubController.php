<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\ManagerRegistry as DoctrineManagerRegistry;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

use function PHPUnit\Framework\throwException;

class ClubController extends AbstractController
{
    private $em;

    public function __construct(PersistenceManagerRegistry $registry)
    {
        $this->em = $registry;
    }

    #[Route('/clubs', name: 'club_index')]
    public function clubIndex() {
        $clubs = $this->em->getRepository(Club::class)->findAll();
        return $this->render("club/index.html.twig",[
            'clubs' => $clubs
        ]);
    }

    #[Route('/club/detail/{id}', name:'club_detail')]
    public function clubDetail($id) {
        $club = $this->em->getRepository(Club::class)->find($id);
        if ($club == null) {
            $this->addFlash('Error', 'Club not found');
            return $this->redirectToRoute('club_index');
        }
        return $this->render('club/detail.html.twig',[
            'club' => $club
        ]);
    }

    #[IsGranted("ROLE_ADMIN"), Route('/club/delete/{id}', name: 'club_delete')]
    public function clubDelete($id) {
        $club = $this->em->getRepository(Club::class)->find($id);
        if ($club == null) {
            $this->addFlash("Error", "Delete club failed!");
        } else {
            $manager = $this->em->getManager();
            $manager->remove($club);
            $manager->flush();
            $this->addFlash("Success", "Delete club success");
        }
        return $this->redirectToRoute("club_index");
    }

    #[IsGranted("ROLE_ADMIN"), Route('/club/add', name: 'club_add')]
    public function clubAdd(Request $request) {
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $images = $club->getImage();
            $imgName = uniqid();
            $imgExtension = $images->guessExtension();
            $imageName = $imgName . "." . $imgExtension;

            try {
                $images->move(
                    $this->getParameter('club_image'), $imageName
                );
            } catch (FileException $e) {
                throwException($e);
            }

            $club->setImage($imageName);

            $manager = $this->em->getManager();
            $manager->persist($club);
            $manager->flush();

            $this->addFlash("Success", "Add club succeed");
            return $this->redirectToRoute('club_index');
        }

        return $this->renderForm("club/add.html.twig",[
            'form' => $form
        ]);
        
    }

    #[IsGranted("ROLE_ADMIN"), Route('/club/edit/{id}', name: 'club_edit')]
    public function clubEdit(Request $request, $id) {
       $club = $this->em->getRepository(Club::class)->find($id);
       $form = $this->createForm(ClubType::class, $club);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           $file = $form['image']->getData();

           if ($file != null) {
               $images = $club->getImage();
               $imgName = uniqid();
               $imgExtension = $images->guessExtension();
               $imageName = $imgName . "." . $imgExtension;

               try {
                   $images->move(
                       $this->getParameter('club_image'), $imageName
                   );
               } catch (FileException $e) {
                   throwException($e);
               }

               $club->setImage($imageName);
           }

           $manager = $this->em->getManager();
           $manager->persist($club);
           $manager->flush();
           $this->addFlash("Success", "Edit club succeed");
           return $this->redirectToRoute('club_index');
       }

       return $this->renderForm("club/edit.html.twig",[
           'form' => $form
       ]);
    }
}
