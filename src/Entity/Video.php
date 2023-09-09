<?php

namespace Alura\Mvc\Entity;

use InvalidArgumentException;

class Video
{
    public readonly int $id;
    public readonly string $url;

    public function __construct(
        string $url, 
        public readonly string $title
    ) {
        $this->setUrl($url);
    }

    public function setUrl(string $url)
    {
       if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        throw new InvalidArgumentException();
       };

       $this->url = $url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // public function setTitle(string $title): void
    // {
    //     $this->title = $title;
    // }
}