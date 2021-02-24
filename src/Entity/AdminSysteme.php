<?php

namespace App\Entity;

use App\Repository\AdminSystemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminSystemeRepository::class)
 */
class AdminSysteme extends User
{


    /**
     * @ORM\OneToMany(targetEntity=Comptes::class, mappedBy="adminSysteme")
     */
    private $comptes;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
    }


    /**
     * @return Collection|Comptes[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Comptes $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setAdminSysteme($this);
        }

        return $this;
    }

    public function removeCompte(Comptes $compte): self
    {
        if ($this->comptes->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getAdminSysteme() === $this) {
                $compte->setAdminSysteme(null);
            }
        }

        return $this;
    }
}
