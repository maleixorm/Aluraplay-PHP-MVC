<?php

$pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
$title = filter_input(INPUT_POST, 'title');
if ($url === false || $title === false) {
    header("Location: /?sucesso=0");
    exit();
}

$sql = "INSERT INTO videos (url, title) VALUES (?, ?)";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $url);
$statement->bindValue(2, $title);

if ($statement->execute() === false) {
    header("Location: /?sucesso=0");
} else {
    header("Location: /?sucesso=1");
}