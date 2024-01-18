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

    #[Route ('/accessibilite.html.twig', name: 'app_accessibilite')]
    public function viewAccessibility(): Response
    {
        return $this->render('profile/accessibilite.html.twig');
    }

    #[Route ('/aide.html.twig', name: 'app_aide')]
    public function viewHelp(): Response
    {
        return $this->render('profile/aide.html.twig');
    }

    #[Route ('/help_login.html.twig', name: 'app_help_login')]
    public function viewHelpLogin(): Response
    {
        return $this->render('profile/help/help_login.html.twig');
    }

    #[Route ('/help_register.html.twig', name: 'app_help_register')]
    public function viewHelpRegister(): Response
    {
        return $this->render('profile/help/help_register.html.twig');
    }

    #[Route ('/help_create_homework.html.twig', name: 'app_help_create_homework')]
    public function viewHelpCreateHomework(): Response
    {
        return $this->render('profile/help/help_create_homework.html.twig');
    }

    #[Route ('/help_see_homework.html.twig', name: 'app_help_see_homework')]
    public function viewHelpSeeHomework(): Response
    {
        return $this->render('profile/help/help_see_homework.html.twig');
    }

    #[Route ('/help_edit_homework.html.twig', name: 'app_help_edit_homework')]
    public function viewHelpEditHomework(): Response
    {
        return $this->render('profile/help/help_edit_homework.html.twig');
    }

    #[Route ('/help_delete_homework.html.twig', name: 'app_help_delete_homework')]
    public function viewHelpDeleteHomework(): Response
    {
        return $this->render('profile/help/help_delete_homework.html.twig');
    }

    #[Route ('/help_disconnect.html.twig', name: 'app_help_disconnect')]
    public function viewHelpDisconnect(): Response
    {
        return $this->render('profile/help/help_disconnect.html.twig');
    }

    #[Route ('/help_comments.html.twig', name: 'app_help_comments')]
    public function viewHelpComments(): Response
    {
        return $this->render('profile/help/help_comments.html.twig');
    }
}