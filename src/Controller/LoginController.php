<?php

namespace Alura\Mvc\Controller;

use PDO;

class LoginController implements Controller
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $passwd = filter_input(INPUT_POST, 'passwd');

        $sql = "SELECT * FROM users WHERE email = ?;";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $email);
        $statement->execute();

        $userData = $statement->fetch(PDO::FETCH_ASSOC);
        $correctPasswd = password_verify($passwd, $userData['passwd'] ?? '');

        if ($correctPasswd) {
            session_start();
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}