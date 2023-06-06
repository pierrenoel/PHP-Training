<?php

namespace app;

class DesignWebsite extends Decorator
{
    /**
     * @return int
     */
    public function getPrice() : int
    {
        return parent::getPrice() + 250;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return parent::getDescription() . ' Add a custom design';
    }
}