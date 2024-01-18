<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Homework;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/{homework}', name: 'app_comment')]
    public function index(EntityManagerInterface $em, Request $request, Homework $homework): Response
    {
        // Créer un nouveau commentaire
        $comment = new Comment();

        // Créer le formulaire
        $form = $this->createForm(CommentType::class, $comment);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ajouter le contenu du commentaire
            $content = $form->get('content')->getData();

            // Ajouter l'utilisateur connecté comme auteur
            $comment->setAuthor($this->getUser());

            // Ajouter la date de création
            $comment->setCreatedAt(new \DateTime());

            // Ajouter le commentaire au devoir
            $comment->setHomework($homework);

            // Ajouter le contenu du commentaire récupéré du formulaire
            $comment->setContent($content);

            // Enregistrer le commentaire dans la base de données
            $em->persist($comment);
            $em->flush();
        }

        return $this->render('comment/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
