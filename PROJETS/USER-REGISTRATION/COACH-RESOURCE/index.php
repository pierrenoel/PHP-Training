<?php

require_once './vendor/autoload.php';

use app\classes\User;

$user = new User('Pierre','pierrenoel@hotmail.be', new \app\classes\EmailSender());

var_dump($user->register());