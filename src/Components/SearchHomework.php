<?php

namespace App\Components;

use App\Entity\Homework;
use App\Repository\HomeworkRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
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

    #[LiveAction]
    public function setHomework(#[LiveArg('homework_id')] ?Homework $homework_id): void
    {
        if(null === $homework_id) {
            $this->homework = null;
            return;
        }
        $this->homework = $this->homeworkRepository->find($homework_id);
    }
}