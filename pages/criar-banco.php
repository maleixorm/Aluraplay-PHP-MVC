<?php

$pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');
$pdo->exec(
    "CREATE TABLE videos (id INTEGER PRIMARY KEY AUTO_INCREMENT, url VARCHAR(250), title VARCHAR(150));"
);