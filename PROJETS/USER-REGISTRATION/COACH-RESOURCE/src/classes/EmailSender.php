<?php

namespace app\classes;

class EmailSender implements EmailSenderInterface
{

    protected array $header = [
        'subject' => 'Welcome to our app',
        'message' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga'
    ];

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @param array $header
     */
    public function setEmail(array $header): void
    {
        $this->header = $header;
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return void
     */
    public function sendEmail(string $to, string $subject, string $message) : void
    {
        // TODO: Implement sendEmail() method.
        // You can use the mail() method or implement a mail package like PHPMailer, ...
    }
}