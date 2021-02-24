<?php

namespace App\Entity;

use App\Repository\AdminAgenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminAgenceRepository::class)
 */
class AdminAgence extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Agences::class, mappedBy="adminAgence", cascade={"persist", "remove"})
     */
    private $agences;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgences(): ?Agences
    {
        return $this->agences;
    }

    public function setAgences(?Agences $agences): self
    {
        // unset the owning side of the relation if necessary
        if ($agences === null && $this->agences !== null) {
            $this->agences->setAdminAgence(null);
        }

        // set the owning side of the relation if necessary
        if ($agences !== null && $agences->getAdminAgence() !== $this) {
            $agences->setAdminAgence($this);
        }

        $this->agences = $agences;

        return $this;
    }
}
