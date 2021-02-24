<?php

namespace App\Entity;

use App\Repository\UserAgenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserAgenceRepository::class)
 */
class UserAgence extends User
{

    /**
     * @ORM\ManyToOne(targetEntity=Agences::class, inversedBy="userAgence")
     */
    private $agences;


    public function getAgences(): ?Agences
    {
        return $this->agences;
    }

    public function setAgences(?Agences $agences): self
    {
        $this->agences = $agences;

        return $this;
    }
}
