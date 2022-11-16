<?php declare(strict_types=1);

namespace App;

interface CloneAbleInterface
{
    public function clone(): self;
}