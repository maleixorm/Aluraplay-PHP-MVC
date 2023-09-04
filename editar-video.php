<?php

$pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
$title = filter_input(INPUT_POST, 'title');
if ($id === false || $url === false || $title === false) {
    header("Location: ./index.php?sucesso=0");
    exit();
}

$sql = "UPDATE videos SET url = :url, title = :title WHERE id = :id;";
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->bindValue(':url', $url);
$statement->bindValue(':title', $title);

if ($statement->execute() === false) {
    header("Location: ./index.php?sucesso=0");
} else {
    header("Location: ./index.php?sucesso=1");
}