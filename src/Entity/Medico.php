<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Medico
 * @package App\Entity
 * @ORM\Entity()
 *
 * Obs: Para adicionar a ORM ao projeto, devemos utilizar o comando composer require symfony/orm-pack
 */
class Medico implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $crm;
    /**
     * @ORM\Column(type="string")
     */private $nome;

    /**
     * @ORM\ManyToOne(targetEntity=Especialidade::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $especialidade;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCrm(): ?int
    {
        return $this->crm;
    }

    public function setCrm(int $crm): self
    {
        $this->crm = $crm;
        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEspecialidade(): ?Especialidade
    {
        return $this->especialidade;
    }

    public function setEspecialidade(?Especialidade $especialidade): self
    {
        $this->especialidade = $especialidade;
        return $this;
    }

    public function toString(): Response {
        return new Response($this->getId().', '.$this->getNome().', '.$this->getCrm().','.$this->getEspecialidade()->getDescricao().'');

    }

    public function jsonSerialize()
    {
        return [
            "id"=>$this->getId(),
            "crm"=>$this->getCrm(),
            "nome"=> $this->getNome(),
            "especialidadeId"=>$this->getEspecialidade()->getId(),
            "especialidadeNome"=>$this->getEspecialidade()->getDescricao()
        ];
    }
}