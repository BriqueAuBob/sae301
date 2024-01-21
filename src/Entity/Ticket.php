<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ticket'), ORM\JoinColumn(nullable: false)]
    private ?Homework $homework = null;

    #[ORM\ManyToOne(inversedBy: 'ticket'), ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(type: 'boolean', options: ['default' => 0])]
    private int|bool|null $status = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomework(): ?Homework
    {
        return $this->homework;
    }

    public function setHomework(Homework $homework): static
    {
        $this->homework = $homework;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function isClose(): ?bool
    {
        if ($this->status == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function setResolved(): static
    {
        $this->status = true;

        return $this;
    }
}
