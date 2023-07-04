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
     * @var int
     */
    protected int $category_id;

    /**
     * @return string
     * @orm varchar(255)
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
     * @orm varchar(255)
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
     * @orm text
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

    /**
     * @return int
     * @orm int
     */
    public function getCategory_id() : int
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     * @return $this
     */
    public function setCategory_id(int $category_id) : self
    {
        $this->category_id = $category_id;
        return $this;
    }
}