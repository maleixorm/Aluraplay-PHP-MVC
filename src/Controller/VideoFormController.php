<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\HtmlRendererTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoFormController implements Controller
{
    use HtmlRendererTrait;
    public function __construct(private VideoRepository $videoRepository) {
        
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        $video = null;
        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->find($id);
        }
        return new Response(200, [], $this->renderTemplate('video-form.php', ['video' => $video]));
    }
}