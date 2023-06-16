<?php

namespace Endeavour\DsExtensions\Tests\Stubs;

class MyObject
{
    public function __construct(private ?string $title = null) {}

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(?string $title = null): self {
        $this->title = $title;

        return $this;
    }
}