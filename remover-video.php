<?php

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

$pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');

$id = $_GET['id'];
$repository = new VideoRepository($pdo);

if ($repository->remove($id) === false) {
    header("Location: /?sucesso=0");
} else {
    header("Location: /?sucesso=1");
}