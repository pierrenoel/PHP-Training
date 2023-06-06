<?php

namespace app\models;

class Post
{
    /**
     * @var string
     */
    protected string $title;
    /**
     * @var string
     */
    protected string $excerpt;
    /**
     * @var string
     */
    protected string $body;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    /**
     * @param string $excerpt
     */
    public function setExcerpt(string $excerpt): self
    {
        $this->excerpt = $excerpt;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }
}