<?php

namespace App\Controller;

use App\Entity\Homework;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\HomeworkType;
use App\Repository\HomeworkRepository;
use Symfony\Component\String\Slugger\SluggerInterface;

class HomeworkController extends AbstractController
{
    #[Route('/homework/{homework}', name: 'app_homework', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, MailerInterface $mailer, Homework $homework = null): Response
    {
        // Créer une instance de Homework si elle n'est pas fournie en paramètre
        if (!$homework) {
            $homework = new Homework();
        }

        // Créer le formulaire en dehors de la condition
        $form = $this->createForm(HomeworkType::class, $homework);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ajouter l'user connecté comme auteur
            $homework->setAuthor($this->getUser());
            //ajouter l'année de l'utilisateur comme année du devoir
            $homework->setYear($this->getUser()->getYear());
            //ajouter le groupe de l'utilisateur comme groupe du devoir
            $homework->setGroup($this->getUser()->getGroup());



            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();

                try {
                    $pictureFile->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) { }

                $homework->setPicture($newFilename);
            }

            $em->persist($homework);
            $em->flush();
            return $this->redirectToRoute('app_index');
        }

        return $this->render('homework/homework.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/homework/{homework}', name: 'app_homework-delete', methods: 'DELETE')]
    public function delete(Request $request, EntityManagerInterface $em, Homework $homework): Response {
        $em->remove($homework);
        $em->flush();
        return $this->redirectToRoute('app_index');
    }

    #[Route('/homework/{homework}/view', name: 'app_homework-view', methods: 'GET')]
    public function view(EntityManagerInterface $entityManager, Request $request):Response{
        //Récupération de {homework}
        $id = $request->get('homework');
        //Récupération de {homework} par  l'entité Homework
        $result = $entityManager->getRepository(Homework::class)->findById($id);

        return $this->render('homework/view.html.twig', [
            'controller_name' => 'ViewHomeworkController',
            'homeworks' => $result,
            'hwID' => $id,
        ]);

    }
}
