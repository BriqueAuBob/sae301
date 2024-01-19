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
        $ajout = false;
        // Créer une instance de Homework si elle n'est pas fournie en paramètre
        if (!$homework) {
            $homework = new Homework();
            $ajout = true;
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
            'ajout' => $ajout
        ]);
    }

    #[Route('/homework/{homework}', name: 'app_homework-delete', methods: 'DELETE')]
    public function delete(Request $request, EntityManagerInterface $em, Homework $homework): Response {
        $em->remove($homework);
        $em->flush();
        return $this->redirectToRoute('app_index');
    }

    #[Route('/homework/{homework}/view', name: 'app_homework-view', methods: 'GET')]
    public function view(Request $request, Homework $homework): Response {
        return $this->render('homework/view.html.twig', [
            'homework' => $homework,
        ]);

    }

    #[Route('/doublon/{id_homework}/{id_doublon}', name: 'app_homework-doublon', methods: 'GET')]
    public function doublon(Request $request, EntityManagerInterface $entityManager): Response {
        // récupérer id_homework et id_doublon
        $id_homework = $request->attributes->get('id_homework');
        $id_doublon = $request->attributes->get('id_doublon');

        // récupérer les deux devoirs
        $homework = $entityManager->getRepository(Homework::class)->findBy(['id' => $id_homework]);
        $doublon = $entityManager->getRepository(Homework::class)->findBy(['id' => $id_doublon]);

        return $this->render('homework/doublon.html.twig', [
            'id_homework' => $id_homework,
            'id_doublon' => $id_doublon,
            'homework' => $homework,
            'doublon' => $doublon,
        ]);
    }
}
