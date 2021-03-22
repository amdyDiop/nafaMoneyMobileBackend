<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AgencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AgencesRepository::class)
 * @ApiResource(
 *     attributes={"pagination_partial"=true,"pagination_client_items_per_page"=true},
 *     routePrefix="/admin",
 *     collectionOperations={
 *       "post"=
 *       {
 *          "method"="post",
 *          "path"="/agences",
 *          "attributes"={"security"="is_granted('ROLE_Admin' or 'ROLE_Admin_Agence')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"},
 *            "denormalization_context"={"groups"={"add:agence"}},
 *       },
 *       "get"=
 *       {
 *          "method"= "get",
 *          "path"="/agences",
 *          "normalization_context"={"groups"={"agence:all"}},
 *       },
 *     },
 *     itemOperations={
 *           "get"=
 *              {
 *               "method"= "get",
 *               "path"="/agence/{id}",
 *               "normalization_context"={"groups"={"agence:all"}},
 *              },
 *          "put"=
 *              {
 *               "method"= "put",
 *               "path"="/agence/{id}",
 *             },
 *     }
 * )
 */
class Agences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"agence:all","compte","caissier:liste","transaction"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=14)
     * @Groups({"add:agence","agence:all","add:compte","compte","caissier:liste","transaction"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"add:agence","transaction","add:agence","agence:all","add:compte","compte","caissier:liste"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"add:agence","agence:all","compte","caissier:liste","transaction"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"add:agence","agence:all","compte","caissier:liste","transaction"})
     */

    private $longitude;

    /**
     * @ORM\Column(type="datetime")
     * @Groups ({"agence:all","compte","caissier:liste","agence:by:user"})
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity=Comptes::class, mappedBy="Agence", cascade={"persist", "remove"})
     * @Groups({"agence:all","agence:by:user"})
     */
    private $comptes;

    /**
     * @ORM\OneToOne(targetEntity=AdminAgence::class, inversedBy="agences", cascade={"persist", "remove"})
     * @Groups ({"agence:all","compte"})
     */
    private $adminAgence;

    /**
     * @ORM\OneToMany(targetEntity=UserAgence::class, mappedBy="agences")
     * @Groups({"agence:all","compte"})
     */
    private $userAgence;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archiver = 0;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="agenceDepot")
     */
    private $transactions;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->userAgence = new ArrayCollection();
        $this->transactions = new ArrayCollection();
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

    public function getArchiver(): ?bool
    {
        return $this->archiver;
    }

    public function setArchiver(bool $archiver): self
    {
        $this->archiver = $archiver;

        return $this;
    }

    /**
     * @return Collection|Transactions[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transactions $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setAgenceDepot($this);
        }

        return $this;
    }

    public function removeTransaction(Transactions $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getAgenceDepot() === $this) {
                $transaction->setAgenceDepot(null);
            }
        }

        return $this;
    }

}



