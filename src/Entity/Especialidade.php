<?php

namespace App\Entity;

use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EspecialidadeRepository::class)
 */
class Especialidade implements \JsonSerializable
{
    # EXPLICAÇÃO PARA O USO DO implementes \JsonSerialize acima:
    # Como os atributos são privados, na hora de da um new JsonResponse, os dados não sairão na tela.
    # Para que isso aconteça, nós a classe Especialdiade implementa a JsonSerialize e,como isso, utilizando o
    # método jsonSerialize(), os dados aparecerão em tela.
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function jsonSerialize()
    {
        return ["id"=>$this->getId(), "descricao"=>$this->getDescricao()];
    }
}
