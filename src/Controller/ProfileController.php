<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CheckRepository;
use App\Repository\HomeworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(CheckRepository $checkRepo, HomeworkRepository $homeworkRepo): Response
    {
        $homeworkChecked = $checkRepo->findBy(['user' => $this->getUser()], ['created_at' => 'DESC']);
        $homeworkPosted = $homeworkRepo->findBy(['author' => $this->getUser()], ['created_at' => 'DESC']);
        return $this->render('profile/profile.html.twig', [
            'homeworksChecked' => $homeworkChecked,
            'homeworksPosted' => $homeworkPosted,
        ]);
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

    #[Route ('/help_homework.html.twig', name: 'app_help_homework')]
    public function viewHelpCreateHomework(): Response
    {
        return $this->render('profile/help/help_homework.html.twig');
    }


    #[Route ('/help_disconnect.html.twig', name: 'app_help_disconnect')]
    public function viewHelpDisconnect(): Response
    {
        return $this->render('profile/help/help_disconnect.html.twig');
    }

}