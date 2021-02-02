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
class Medico
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="integer")
     */
    public $crm;
    /**
     * @ORM\Column(type="string")
     */public $nome;

    /**
     * @ORM\ManyToOne(targetEntity=Especialidade::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $especialidade;

    public function getEspecialidade(): ?Especialidade
    {
        return $this->especialidade;
    }

    public function setEspecialidade(?Especialidade $especialidade): self
    {
        $this->especialidade = $especialidade;

        return $this;
    }



}