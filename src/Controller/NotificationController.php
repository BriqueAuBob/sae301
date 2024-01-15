<?php

namespace App\Controller;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_notification-delete-all'))
            ->setMethod('DELETE')
            ->getForm();

        $notifications = $this->em->getRepository(Notification::class)->findBy([
            'user' => $this->getUser(),
        ]);

        return $this->render('notification/index.html.twig', [
            'notifications' => $notifications,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/notification/delete-all', name: 'app_notification-delete-all', methods: 'DELETE')]
    public function deleteAll(Request $request, EntityManagerInterface $em): Response {
        $notifications = $this->em->getRepository(Notification::class)->findBy([
            'user' => $this->getUser(),
        ]);
        foreach ($notifications as $notification) {
            $em->remove($notification);
        }
        return $this->redirectToRoute('app_notification');
    }

    #[Route('/notification/{notification}', name: 'app_notification-delete', methods: 'DELETE')]
    public function delete(Request $request, EntityManagerInterface $em, Notification $notification): Response {
        $em->remove($notification);
        $em->flush();
        return $this->redirectToRoute('app_notification');
    }
}
