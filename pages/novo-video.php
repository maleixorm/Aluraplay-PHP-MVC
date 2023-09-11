<?php

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

$pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
$title = filter_input(INPUT_POST, 'title');
if ($url === false || $title === false) {
    header("Location: /?sucesso=0");
    exit();
}

$repository = new VideoRepository($pdo);

if ($repository->add(new Video($url, $title)) === false) {
    header("Location: /?sucesso=0");
} else {
    header("Location: /?sucesso=1");
}