<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class VideoFormController extends ControllerWithHtml implements Controller
{
    public function __construct(private VideoRepository $videoRepository) {
        
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $video = null;
        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->find($id);
        }
        $this->renderTemplate('video-form.php', ['video' => $video]);
    }
}