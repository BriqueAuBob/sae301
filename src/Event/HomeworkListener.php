<?php

namespace App\Event;

use App\Entity\Homework;
use App\Entity\Notification;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Homework::class)]
class HomeworkListener
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function postPersist(Homework $homework, PostPersistEventArgs $event): void
    {
        foreach($this->userRepository->findByGroup($homework->getGroup(), $homework->getYear(), $homework->getSubject()->getCourse()->getId()) as $user) {
            $notification = new Notification();
            $notification->setTitle('Nouveau devoir');
            $notification->setMessage("Le devoir \"{$homework->getName()}\" a été ajouté à la matière {$homework->getSubject()->getName()}.");
            $notification->setUser($user);
            $notification->setNotDatetimeCreate(new \DateTime('now'));

            $event->getObjectManager()->persist($notification);
        }
        $event->getObjectManager()->flush();
    }
}