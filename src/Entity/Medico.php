<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Medico
 * @package App\Entity
 * @ORM\Entity()
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



}