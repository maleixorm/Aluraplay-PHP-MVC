<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RemoveCapaController implements Controller
{
    public function __construct(private VideoRepository $videoRepository) {
        
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
            if ($id === false || $id === null) {
                $_SESSION['error_message'] = 'ID não encontrado!';
                return new Response(302, [
                    'Location' => '/'
                ]);
            }
        
        $success = $this->videoRepository->removeCapa($id);

        if ($success === false)  {
            $_SESSION['error_message'] = 'Erro ao tentar remover uma capa!';
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            return new Response(302, [
                'Location' => '/'
            ]);
        }    
    }    
}