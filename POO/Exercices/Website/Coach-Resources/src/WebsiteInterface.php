<?php

namespace app;

interface WebsiteInterface
{
    /**
     * @return int
     */
    public function getPrice() : int;

    /**
     * @return string
     */
    public function getDescription() : string;
}