<?php

namespace App\Controller;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/notification', name: 'app_notification')]
    public function index(): Response
    {

        $notifications = $this->em->getRepository(Notification::class)->findBy([
            'user' => $this->getUser(),
        ]);

        return $this->render('notification/index.html.twig', [
            'notifications' => $notifications,
        ]);
    }
    #[Route('/notification/{notification}', name: 'app_notification-delete', methods: 'DELETE')]
    public function delete(Request $request, EntityManagerInterface $em, Notification $notification): Response {
        $em->remove($notification);
        $em->flush();
        return $this->redirectToRoute('app_notification');
    }
}
