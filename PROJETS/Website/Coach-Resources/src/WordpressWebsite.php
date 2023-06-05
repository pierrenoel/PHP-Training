<?php

namespace app;

class WordpressWebsite extends Decorator
{
    public function getPrice() : int
    {
        return parent::getPrice() + 3500;
    }

    public function getDescription(): string
    {
        return parent::getDescription() . ' Transform into a Wordpress project';
    }
}