<?php

namespace App\Domain\Entity;

class Article
{
    private $id;
    private $title;
    private $text;

    public function setId($id): Article
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): Article
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): Article
    {
        $this->text = $text;

        return $this;
    }

    public function getData(): array
    {
        return get_object_vars($this);
    }
}