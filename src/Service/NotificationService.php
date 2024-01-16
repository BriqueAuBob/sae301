<?php
namespace App\Service;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUnreadNotificationCount($userId): int
    {
        $unreadNotifications = $this->entityManager->getRepository(Notification::class)->findBy([
            'user' => $userId,
            'isRead' => false,
        ]);

        return count($unreadNotifications);
    }
}
