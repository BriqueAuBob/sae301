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
        // formulaire pour supprimer toutes les notifications
        $deleteAllButton = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_notification-delete-all'))
            ->setMethod('DELETE')
            ->getForm();
        //formulaire pour marquer toutes les notifications comme lues
        $readAllButton = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_notification-read-all'))
            ->setMethod('PATCH')
            ->getForm();

        $notifications = $this->em->getRepository(Notification::class)->findBy(
            ['user' => $this->getUser()],
            ['isRead' => 'ASC', 'created_at' => 'DESC']
        );

        $readNotificationsCount = array_reduce($notifications, function ($count, $notification) {
            return $count + ($notification->isIsRead() ? 0 : 1);
        }, 0);

        return $this->render('notification/index.html.twig', [
            'notifications' => $notifications,
            'readNotificationsCount' => $readNotificationsCount,
            'deleteAllButton' =>$deleteAllButton->createView(),
            'readAllButton' =>$readAllButton->createView(),
        ]);
    }

    #[Route('/notification/read-all', name: 'app_notification-read-all', methods: 'PATCH')]
    public function readAll(Request $request, EntityManagerInterface $em): Response {

        $notifications = $em->getRepository(Notification::class)->findBy([
            'user' => $this->getUser(),
        ]);

        foreach ($notifications as $notification) {
            $notification->setIsRead(true);
        }

        $em->flush();
        return $this->redirectToRoute('app_notification');
    }

    #[Route('/notification/{id}', name: 'app_notification-is-read', methods: 'PATCH')]
    public function isRead(Request $request, EntityManagerInterface $em, $id): Response {
        $notification = $em->getRepository(Notification::class)->find($id);

        if (!$notification) {
            return new Response('Notification introuvable', 404);
        }

        $notification->setIsRead(true);
        $em->flush();
        return $this->redirectToRoute('app_notification');
    }



    #[Route('/notification/delete-all', name: 'app_notification-delete-all', methods: 'DELETE')]
    public function deleteAll(Request $request, EntityManagerInterface $em): Response {

        $notifications = $em->getRepository(Notification::class)->findBy([
            'user' => $this->getUser(),
        ]);

        foreach ($notifications as $notification) {
            $em->remove($notification);
        }

        $em->flush();
        return $this->redirectToRoute('app_notification');
    }

    #[Route('/notification/{notification}', name: 'app_notification-delete', methods: 'DELETE')]
    public function delete(Request $request, EntityManagerInterface $em, Notification $notification): Response {
        $em->remove($notification);
        $em->flush();
        return $this->redirectToRoute('app_notification');
    }
}
