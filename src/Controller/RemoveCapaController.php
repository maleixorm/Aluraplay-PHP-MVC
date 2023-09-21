<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class RemoveCapaController implements Controller
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
        
        $success = $this->videoRepository->removeCapa($id);

        if ($success === false)  {
            header("Location: /?sucesso=0");
            return;
        } else {
            header("Location: /?sucesso=1");
            return;
        }    
    }    
}