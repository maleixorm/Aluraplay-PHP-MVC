<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class EditVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository) {
        
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($id === false || $id === null) {
                header("Location: /?sucesso=0");
                return;
            }
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
            if ($url === false) {
                header("Location: /?sucesso=0");
                return;
            }
        $title = filter_input(INPUT_POST, 'title');
            if ($title === false) {
                header("Location: /?sucesso=0");
                return;
            }

        $video = new Video($url, $title);
        $video->setId($id);

        $success = $this->videoRepository->update($video);

        if ($success === false)  {
            header("Location: /?sucesso=0");
            return;
        } else {
            header("Location: /?sucesso=1");
            return;
        }
    }
}