<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use finfo;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EditVideoController implements Controller
{
    use FlashMessageTrait;
    public function __construct(private VideoRepository $videoRepository) {
        
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $requestBody = $request->getParsedBody();
        $id = filter_var($requestBody['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addErrorMessage('ID inválido!');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $url = filter_var($requestBody['url'], FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('URL inválida!');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $title = filter_var($requestBody['title']);
        if ($title === false) {
            $this->addErrorMessage('Título não informado!');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $video = new Video($url, $title);
        $video->setId($id);

        $files = $request->getUploadedFiles();
        $uploadedImage = $files['image'];

        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);
            
            if (str_starts_with($mimeType, 'image/')) {
                $safeFileName = uniqid('upload_') . '_' . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
                $uploadedImage->moveTo(__DIR__ . '/../../public/img/uploads/' . $safeFileName);
                $video->setFilePath($safeFileName);
            }
        }

        $success = $this->videoRepository->update($video);
        if ($success === false)  {
            $this->addErrorMessage('Erro ao tentar atualizar o vídeo!');
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