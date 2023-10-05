<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;

class DeleteVideoController implements Controller
{
    use FlashMessageTrait;
    public function __construct(private VideoRepository $videoRepository) {
        
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($id === false || $id === null) {
                $this->addErrorMessage('ID não encontrato!');
                header("Location: /");
                return;
            }
        
        $success = $this->videoRepository->remove($id);

        if ($success === false)  {
            $this->addErrorMessage('Não foi possível remover o vídeo selecionado!');
            header("Location: /");
            return;
        } else {
            header("Location: /?sucesso=1");
            return;
        }    
    }    
}