<?php

namespace App\Entity;

use App\Repository\AgencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgencesRepository::class)
 */
class Agences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity=Comptes::class, mappedBy="Agence", cascade={"persist", "remove"})
     */
    private $comptes;

    /**
     * @ORM\OneToOne(targetEntity=AdminAgence::class, inversedBy="agences", cascade={"persist", "remove"})
     */
    private $adminAgence;

    /**
     * @ORM\OneToMany(targetEntity=UserAgence::class, mappedBy="agences")
     */
    private $userAgence;

    public function __construct()
    {
        $this->userAgence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getComptes(): ?Comptes
    {
        return $this->comptes;
    }

    public function setComptes(Comptes $comptes): self
    {
        // set the owning side of the relation if necessary
        if ($comptes->getAgence() !== $this) {
            $comptes->setAgence($this);
        }

        $this->comptes = $comptes;

        return $this;
    }

    public function getAdminAgence(): ?AdminAgence
    {
        return $this->adminAgence;
    }

    public function setAdminAgence(?AdminAgence $adminAgence): self
    {
        $this->adminAgence = $adminAgence;

        return $this;
    }

    /**
     * @return Collection|UserAgence[]
     */
    public function getUserAgence(): Collection
    {
        return $this->userAgence;
    }

    public function addUserAgence(UserAgence $userAgence): self
    {
        if (!$this->userAgence->contains($userAgence)) {
            $this->userAgence[] = $userAgence;
            $userAgence->setAgences($this);
        }

        return $this;
    }

    public function removeUserAgence(UserAgence $userAgence): self
    {
        if ($this->userAgence->removeElement($userAgence)) {
            // set the owning side to null (unless already changed)
            if ($userAgence->getAgences() === $this) {
                $userAgence->setAgences(null);
            }
        }

        return $this;
    }
}
