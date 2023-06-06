<?php

require_once './vendor/autoload.php';

use app\classes\User;

$user = new User('Pierre','user@mywebsite.com', new \app\classes\EmailSender());

// The mail is automatically sent :) and the user is of course record into the database
$user->register();
