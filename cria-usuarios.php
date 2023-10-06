<?php

$pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');

$email = $argv[1];
$passwd = $argv[2];
$hash = password_hash($passwd, PASSWORD_ARGON2ID);

$sql = "INSERT INTO users (email, passwd) VALUES (?, ?);";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $email);
$statement->bindValue(2, $hash);
$statement->execute();

if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
    $statement = $this->pdo->prepare('UPDATE users SET passwd = ? WHERE id = ?');
    $statement->bindValue(1, password_hash($passwd, PASSWORD_ARGON2ID));
    $statement->bindValue(2, $userData['id']);
    $statement->execute();
}