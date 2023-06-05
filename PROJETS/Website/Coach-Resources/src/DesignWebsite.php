<?php

namespace app;

class DesignWebsite extends Decorator
{
    public function getPrice() : int
    {
        return parent::getPrice() + 250;
    }

    public function getDescription(): string
    {
        return parent::getDescription() . ' Add a custom design';
    }
}