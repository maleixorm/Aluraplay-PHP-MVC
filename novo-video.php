<?php

$pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');

$sql = "INSERT INTO videos (url, title) VALUES (?, ?)";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $_POST['url']);
$statement->bindValue(2, $_POST['title']);

if ($statement->execute() === false) {
    header("Location: index.php?sucesso=0");
} else {
    header("Location: index.php?sucesso=1");
}