<?php

namespace app;

abstract class Decorator implements WebsiteInterface
{
    protected WebsiteInterface $website;

    public function __construct(WebsiteInterface $website)
    {
        $this->website = $website;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->website->getPrice();
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->website->getDescription();
    }


}