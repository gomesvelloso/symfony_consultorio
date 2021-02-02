<?php


namespace App\Helper;


use App\Entity\Especialidade;

class EspecialidadeFactory
{
    public function criarEspecialdiade(string $json): Especialidade
    {
        $dadosEmJson = json_decode($json);

        $especialidade = new Especialidade();
        $especialidade->setDescricao($dadosEmJson->descricao);
        return $especialidade;
    }

}