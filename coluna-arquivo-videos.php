<?php

$pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');

$pdo->exec("ALTER TABLE videos ADD image_path VARCHAR(150);");