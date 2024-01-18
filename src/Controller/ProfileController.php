<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/profile.html.twig');
    }

    #[Route('/profil/informations', name: 'app_profile_informations')]
    public function viewSettings(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $manager->flush();

            return $this->redirectToRoute('app_profile_informations');
        }

        return $this->render('profile/infos.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/mentions-legales', name: 'app_mentions')]
    public function viewMentions(): Response
    {
        return $this->render('profile/mentions.html.twig');
    }

    #[Route ('/accessibilite.html.twig', name: 'app_accessibilite')]
    public function viewAccessibility(): Response
    {
        return $this->render('profile/accessibilite.html.twig');
    }
}