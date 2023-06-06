<?php

namespace app;

class BasicWebsite implements WebsiteInterface
{
    /**
     * @return int
     */
    public function getPrice(): int
    {
        return '1000';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'This is a basic website';
    }
}