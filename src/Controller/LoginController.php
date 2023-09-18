<?php

namespace Alura\Mvc\Controller;
use PDO;

class LoginController implements Controller
{
    public function __construct(private PDO $pdo)
    {
    
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $passwd = filter_input(INPUT_POST, 'passwd');

        $sql = 'SELECT * FROM users WHERE email = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $email);
        $statement->execute();

        $userData = $statement->fetch(PDO::FETCH_ASSOC);
        $correctPasswd = password_verify($passwd, $userData['passwd'] ?? '');

        if ($correctPasswd) {
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}