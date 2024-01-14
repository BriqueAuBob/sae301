<?php

namespace App\Event;

use App\Entity\Homework;
use App\Entity\Notification;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Notification::class)]
class NotificationListener
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function postPersist(Notification $notification, PostPersistEventArgs $event): void
    {
        $email = new Email();
        $email->from('contact@iutask.com')
            ->to($notification->getUser()->getEmail())
            ->subject($notification->getTitle())
            ->html('<p>'.$notification->getMessage().'</p>');

        $this->mailer->send($email);
    }
}