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
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('app_comment', ['homework' => $homework->getId()]),
            'method' => 'POST',
        ]);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $content = $form->get('content')->getData();

            $comment->setAuthor($this->getUser());
            $comment->setCreatedAt(new \DateTime());
            $comment->setHomework($homework);
            $comment->setContent($content);

            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a bien été ajouté.');
            return $this->redirectToRoute('app_index');
        }

        return $this->render('comment/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
