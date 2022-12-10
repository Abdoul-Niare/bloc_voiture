<?php

namespace App\Entity;

use App\Repository\FavoriRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriRepository::class)]
class Favori
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    private ?User $annonceFav = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    private ?annonce $UsersFav = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnonceFav(): ?User
    {
        return $this->annonceFav;
    }

    public function setAnnonceFav(?User $annonceFav): self
    {
        $this->annonceFav = $annonceFav;

        return $this;
    }

    public function getUsersFav(): ?annonce
    {
        return $this->UsersFav;
    }

    public function setUsersFav(?annonce $UsersFav): self
    {
        $this->UsersFav = $UsersFav;

        return $this;
    }
}
