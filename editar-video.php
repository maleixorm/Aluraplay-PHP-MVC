<?php

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

$pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header("Location: /?sucesso=0");
    exit();
}
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header("Location: /?sucesso=0");
    exit();
}
$title = filter_input(INPUT_POST, 'title');
if ($title === false) {
    header("Location: /?sucesso=0");
    exit();
}

$video = new Video($url, $title);
$video->setId($id);

$repository = new VideoRepository($pdo);

if ($repository->update(new Video($url, $title)) === false)  {
    header("Location: /?sucesso=0");
    exit();
} else {
    header("Location: /?sucesso=1");
    exit();
}