<?php


namespace App\Helper;


use App\Entity\Medico;

class MedicoFactory
{
    public function criarMedico(string $json): Medico
    {
        $dadosEmJson     = json_decode($json);

        $medico = new Medico();
        $medico->crm  = $dadosEmJson->crm;
        $medico->nome = $dadosEmJson->nome;

        return $medico;
    }

}