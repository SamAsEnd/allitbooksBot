<?php

namespace Andegna\AllItBooksBot;

class Node
{
    /** @var  string */
    private $thumbnail;

    /** @var  string */
    private $description;

    /** @var  string */
    private $stats;

    /** @var  string */
    private $file;

    /** @var  string */
    private $title;

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     * @return Node
     */
    public function setThumbnail(string $thumbnail): Node
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Node
     */
    public function setDescription(string $description): Node
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getStats(): string
    {
        return $this->stats;
    }

    /**
     * @param string $stats
     * @return Node
     */
    public function setStats(string $stats): Node
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     * @return Node
     */
    public function setFile(string $file): Node
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Node
     */
    public function setTitle(string $title): Node
    {
        $this->title = $title;

        return $this;
    }

}
