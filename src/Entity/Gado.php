<?php

namespace App\Entity;

use App\Repository\GadoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GadoRepository::class)]
class Gado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(
        message: 'O valor deve ser positivo ou 0'
    )]
    private ?int $codigo = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(
        message: 'O valor deve ser positivo ou 0'
    )]
    private ?float $leite = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(
        message: 'O valor deve ser positivo ou 0'
    )]
    private ?float $racao = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(
        message: 'O valor deve ser positivo ou 0'
    )]
    private ?float $peso = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(
        message: 'O valor deve ser positivo ou 0'
    )]
    private ?bool $estado = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $nascimento = null;

    public function __construct() 
    {
        $this->estado = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getLeite(): ?float
    {
        return $this->leite;
    }

    public function setLeite(float $leite): self
    {
        $this->leite = $leite;

        return $this;
    }

    public function getRacao(): ?float
    {
        return $this->racao;
    }

    public function setRacao(float $racao): self
    {
        $this->racao = $racao;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function isEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getNascimento(): ?\DateTimeInterface
    {
        return $this->nascimento;
    }

    public function setNascimento(\DateTimeInterface $nascimento): self
    {
        $this->nascimento = $nascimento;

        return $this;
    }

   
}
