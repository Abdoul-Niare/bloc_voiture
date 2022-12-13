<?php

namespace App\Entity;

use App\Repository\AnnonceListByUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceListByUserRepository::class)]
class AnnonceListByUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'annonceFav')]
    private ?User $users = null;

    #[ORM\ManyToOne(inversedBy: 'usersFav')]
    private ?Annonce $annonces = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getAnnonces(): ?Annonce
    {
        return $this->annonces;
    }

    public function setAnnonces(?Annonce $annonces): self
    {
        $this->annonces = $annonces;

        return $this;
    }
}
