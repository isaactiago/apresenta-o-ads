<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class TaskInputDTO
{
    #[Assert\NotBlank(message: 'Informe o título da tarefa.', normalizer: 'trim')]
    #[Assert\Length(max: 120, maxMessage: 'O título deve ter no máximo {{ limit }} caracteres.', normalizer: 'trim')]
    public ?string $title = null;

    public ?string $description = null;
}
