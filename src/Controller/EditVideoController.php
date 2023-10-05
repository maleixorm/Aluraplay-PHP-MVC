<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use finfo;

class EditVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository) {
        
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($id === false || $id === null) {
                $_SESSION['error_message'] = 'ID inválido!';
                header("Location: /");
                return;
            }
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
            if ($url === false) {
                $_SESSION['error_message'] = 'URL inválido!';
                header("Location: /");
                return;
            }
        $title = filter_input(INPUT_POST, 'title');
            if ($title === false) {
                $_SESSION['error_message'] = 'Título inválido!';
                header("Location: /");
                return;
            }

        $video = new Video($url, $title);
        $video->setId($id);

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $safeFileName = uniqid('upload_') . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['image']['tmp_name']);
            if (str_starts_with($mimeType, 'image/')) {
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $video->setFilePath($safeFileName);
            }
        }

        $success = $this->videoRepository->update($video);

        if ($success === false)  {
            $_SESSION['error_message'] = 'Erro ao tentar atualizar o vídeo!';
            header("Location: /");
            return;
        } else {
            header("Location: /?sucesso=1");
            return;
        }
    }
}