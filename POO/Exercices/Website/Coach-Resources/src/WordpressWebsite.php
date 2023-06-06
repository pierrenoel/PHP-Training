<?php

namespace app;

class WordpressWebsite extends Decorator
{
    /**
     * @return int
     */
    public function getPrice() : int
    {
        return parent::getPrice() + 3500;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return parent::getDescription() . ' Transform into a Wordpress project';
    }
}