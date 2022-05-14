<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateCreate;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $contenu;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'message')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'boolean')]
    private $isFromEcole;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreate(): ?string
    {
        return $this->dateCreate;
    }

    public function setDateCreate(?string $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsFromEcole(): ?bool
    {
        return $this->isFromEcole;
    }

    public function setIsFromEcole(bool $isFromEcole): self
    {
        $this->isFromEcole = $isFromEcole;

        return $this;
    }
}
