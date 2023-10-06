<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class LoginController implements Controller
{
    use FlashMessageTrait;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=phpmvc', 'php', '123456');
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $email = filter_var($queryParams['email'], FILTER_VALIDATE_EMAIL);
        $passwd = filter_var($queryParams['passwd']);

        $sql = "SELECT * FROM users WHERE email = ?;";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $email);
        $statement->execute();

        $userData = $statement->fetch(PDO::FETCH_ASSOC);
        $correctPasswd = password_verify($passwd, $userData['passwd'] ?? '');

        if (!$correctPasswd) {
            $this->addErrorMessage('Usuário ou senha inválidos!');
            return new Response(302, [
                'Location' => '/login'
            ]);
        } 
        
        if (password_needs_rehash($userData['passwd'], PASSWORD_ARGON2ID)) {
            $statement = $this->pdo->prepare('UPDATE users SET passwd = ? WHERE id = ?');
            $statement->bindValue(1, password_hash($passwd, PASSWORD_ARGON2ID));
            $statement->bindValue(2, $userData['id']);
            $statement->execute();
        }

        $_SESSION['logado'] = true;
        return new Response(302, [
            'Location' => '/'
        ]);
    }
}