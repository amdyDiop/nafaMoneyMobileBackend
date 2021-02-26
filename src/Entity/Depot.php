<?php

namespace App\Entity;

use App\Repository\DepotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DepotRepository::class)
 */
class Depot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"caissier:liste"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Caissier::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $caissier;

    /**
     * @ORM\ManyToOne(targetEntity=Comptes::class)
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity=AdminSysteme::class, inversedBy="depots")
     */
    private $adminSysteme;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaissier(): ?Caissier
    {
        return $this->caissier;
    }

    public function setCaissier(?Caissier $caissier): self
    {
        $this->caissier = $caissier;
        return $this;
    }

    public function getCompte(): ?Comptes
    {
        return $this->compte;
    }

    public function setCompte(?Comptes $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getAdminSysteme(): ?AdminSysteme
    {
        return $this->adminSysteme;
    }

    public function setAdminSysteme(?AdminSysteme $adminSysteme): self
    {
        $this->adminSysteme = $adminSysteme;

        return $this;
    }
}
