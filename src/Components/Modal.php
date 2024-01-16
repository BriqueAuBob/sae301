<?php

namespace App\Components;

use App\Entity\Homework;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class Modal
{
    use DefaultActionTrait;

    public string $id = '';

    #[LiveProp(writable: true)]
    public ?Homework $homework;
}