<?php

namespace App\Components;

use App\Entity\Homework;
use App\Repository\HomeworkRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class SearchHomework
{
    use DefaultActionTrait;

    #[LiveProp]
    public string $icon = '';

    #[LiveProp]
    public string $placeholder = '';

    #[LiveProp(writable: true)]
    public string $query = '';

    #[LiveProp(writable: true)]
    public ?Homework $homework = null;

    public function __construct(private HomeworkRepository $homeworkRepository)
    {
    }

    public function getHomeworks(): array
    {
        return $this->homeworkRepository->search($this->query);
    }

    #[LiveListener('setHomework')]
    public function setHomework(#[LiveArg] ?Homework $homework): void
    {
        $this->homework = $homework;
    }
}