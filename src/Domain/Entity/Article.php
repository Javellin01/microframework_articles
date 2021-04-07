<?php

namespace App\Domain\Entity;

class Article
{
    private $id;
    private $title;
    private $text;
    private $author;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getText(): string
    {
        return $this->text;
    }


    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return int
     */
    public function getAuthor(): int
    {
        return $this->author;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setAuthor(int $userId): self
    {
        $this->author = $userId;

        return $this;
    }

    public function getData(): array
    {
        return get_object_vars($this);
    }
}