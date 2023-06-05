<?php

require_once './vendor/autoload.php';

$basic = new \app\WordpressWebsite(new \app\DesignWebsite(new \app\BasicWebsite()));

echo $basic->getPrice(). '€ => ' .$basic->getDescription();