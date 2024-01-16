<?php

namespace App\Controller;

use App\Entity\Homework;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupération des homeworks
        $homeworks = $entityManager->getRepository(Homework::class)->findAll();

        return $this->render('calendar/index.html.twig', [
            'controller_name' => 'CalendarController',
            'homeworks' => $homeworks,
        ]);
    }
}
