<?php

namespace app;

interface WebsiteInterface
{
    public function getPrice() : int;
    public function getDescription() : string;
}