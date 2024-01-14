<?php

namespace App\Entity;

use App\Repository\CheckRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckRepository::class)]
#[ORM\Table(name: '`check`')]
class Check
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'checks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'checks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Homework $homework_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $che_usr_id): static
    {
        $this->user_id = $che_usr_id;

        return $this;
    }

    public function getHomework(): ?Homework
    {
        return $this->homework_id;
    }

    public function setCheHwId(?Homework $che_hw_id): static
    {
        $this->homework_id = $che_hw_id;

        return $this;
    }

    public function getHwDatetimeCreate(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setHwDatetimeCreate(\DateTimeInterface $hw_datetime_create): static
    {
        $this->created_at = $hw_datetime_create;

        return $this;
    }
}
