<?php

namespace app;

class BasicWebsite implements WebsiteInterface
{
    public function getPrice(): int
    {
        return '1000';
    }

    public function getDescription(): string
    {
        return 'This is a basic website';
    }
}