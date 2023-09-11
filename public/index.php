<?php

use Alura\Mvc\Controller\{Controller, VideoListController, VideoFormController, NewVideoController, Error404Controller, EditVideoController, DeleteVideoController};
use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . "/../vendor/autoload.php";

$pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');
$videoRepository = new VideoRepository($pdo);

$routes = require_once __DIR__ . '../../config/routes.php';
$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$pathInfo";
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];
    $controller = new $controllerClass($videoRepository);
} else {
    $controller = new Error404Controller();
}

/** @var Controller $controller */
$controller->processaRequisicao();