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
        $user = $notification->getUser();
        $emails = [$user->getEmail()];
        $emails = array_merge($emails, array_map(function($email) {
            return $email->getEmail();
        }, $user->getEmails()->toArray()));

        foreach ($emails as $email) {
            $mail = new Email();
            $mail->from('contact@iutask.com')
                ->to($email)
                ->subject($notification->getTitle())
                ->html('<p>'.$notification->getMessage().'</p>');

            $this->mailer->send($mail);
        }
    }
}