<?php

namespace App\Entity;

use App\Repository\EspecialidadeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EspecialidadeRepository", repositoryClass=EspecialidadeRepository::class)
 */
class Especialidade implements \JsonSerializable
{
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

    /**
     * @ORM\OneToMany(targetEntity=Medico::class, mappedBy="especialidade", orphanRemoval=true)
     */
    private $medicos;

    public function __construct()
    {
        $this->medicos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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

    /**
     * @return Collection|Medico[]
     */
    public function getMedicos(): Collection
    {
        return $this->medicos;
    }

    public function addMedico(Medico $medico): self
    {
        if (!$this->medicos->contains($medico)) {
            $this->medicos[] = $medico;
            $medico->setEspecialidade($this);
        }

        return $this;
    }

    public function removeMedico(Medico $medico): self
    {
        if ($this->medicos->removeElement($medico)) {
            // set the owning side to null (unless already changed)
            if ($medico->getEspecialidade() === $this) {
                $medico->setEspecialidade(null);
            }
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "id"=>$this->getId(),
            "descricao"=>$this->getDescricao()
        ];
    }
}
