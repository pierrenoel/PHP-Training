<?php

namespace app;

abstract class Decorator implements WebsiteInterface
{
    protected WebsiteInterface $website;

    public function __construct(WebsiteInterface $website)
    {
        $this->website = $website;
    }

    public function getPrice(): int
    {
        return $this->website->getPrice();
    }

    public function getDescription(): string
    {
        return $this->website->getDescription();
    }


}