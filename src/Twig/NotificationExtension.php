<?php

namespace App\Twig;

use App\Service\NotificationService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NotificationExtension extends AbstractExtension
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('unread_notification_count', [$this, 'getUnreadNotificationCount']),
        ];
    }

    public function getUnreadNotificationCount($userId)
    {
        return $this->notificationService->getUnreadNotificationCount($userId);
    }
}
