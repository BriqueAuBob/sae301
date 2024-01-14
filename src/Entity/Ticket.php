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
    private ?Homework $hw_id;

    #[ORM\ManyToOne(inversedBy: 'ticket'), ORM\JoinColumn(nullable: false)]
    private ?User $author_id = null;

    #[ORM\Column(type: 'boolean', options: ['default' => 0])]
    private int|bool|null $status = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomework(): ?Homework
    {
        return $this->hw_id;
    }

    public function getAuthor(): ?User
    {
        return $this->author_id;
    }

    public function isOpen(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }
}
