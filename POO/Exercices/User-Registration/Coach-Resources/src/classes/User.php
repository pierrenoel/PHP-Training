<?php

namespace app\classes;

class User
{
    public function __construct(
        protected string $name,
        protected string $email,
        protected EmailSenderInterface $emailSender
    ){}

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return $this
     */
    public function register() : self
    {
        // TODO: Validate the data (you can use an DI)

        // TODO: Record the user into the database

        // Send a welcome email
        $this->emailSender->sendEmail($this->email, $this->emailSender->getHeader()['subject'],$this->emailSender->getHeader()['message']);

        return $this;
    }

}