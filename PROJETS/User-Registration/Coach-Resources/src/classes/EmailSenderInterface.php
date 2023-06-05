<?php

namespace app\classes;

interface EmailSenderInterface
{
    public function sendEmail(string $to, string $subject, string $message);
}