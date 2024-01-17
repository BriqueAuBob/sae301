<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/profile.html.twig');
    }

    #[Route('/parametres', name: 'app_settings')]
    public function viewSettings(): Response
    {
        return $this->render('profile/settings.html.twig');
    }

    #[Route('/mentions-legales', name: 'app_mentions')]
    public function viewMentions(): Response
    {
        return $this->render('profile/mentions.html.twig');
    }
}