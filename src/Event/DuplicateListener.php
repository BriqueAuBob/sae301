<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Service\duplicateVerifService;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class DuplicateListener implements EventSubscriberInterface
{
    private duplicateVerifService $duplicateVerifService;

    //Constructeur
    public function __construct(duplicateVerifService $duplicateVerifService)
    {
        $this->duplicateVerifService = $duplicateVerifService;
    }

    // Execution DuplicateVerifService à chaque requête
    public function onKernelRequest(RequestEvent $event): void
    {
        $this->duplicateVerifService->execute();
    }

    // Déclaration des événements écoutés
    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}