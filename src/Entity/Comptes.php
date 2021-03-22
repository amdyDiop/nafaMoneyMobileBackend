<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComptesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ComptesRepository::class)
 * @ApiResource(
 *     attributes={"pagination_partial"=true,"pagination_client_items_per_page"=true},
 *     routePrefix="/admin",
 *     collectionOperations={
 *       "post"=
 *       {
 *          "method"="post",
 *          "path"="/comptes",
 *          "attributes"={"security"="is_granted('ROLE_Admin')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"},
 *          "denormalization_context"={"groups"={"add:compte"}},
 *       },
 *       "get"=
 *       {
 *          "method"= "get",
 *          "path"="/comptes",
 *          "normalization_context"={"groups"={"compte"}},
 *       },
 *     },
 *     itemOperations={
 *          "get"=
 *              {
 *                "methode"="get",
 *                "path"="/compte/{id}",
 *                "security"="is_granted('ROLE_Admin')",
 *                "security_message"="Vous n'avez pas access à cette Ressource",
 *                 "normalization_context"={"groups"={"compte"}},
 *                },
 *              "put"=
 *              {
 *                "methode"="put",
 *                "path"="/compte/{id}",
 *                "security"="is_granted('ROLE_Admin')",
 *                "security_message"="Vous n'avez pas access à cette Ressource",
 *                 "normalization_context"={"groups"={"compte:edit"}},
 *                },
 *             "delete"=
 *               {
 *                "methode"="delete",
 *                "path"="/compte/{id}",
 *                "security"="is_granted('ROLE_Admin')",
 *                "security_message"="Vous n'avez pas access à cette Ressource",
 *                },
 *      },
 * )
 */
class Comptes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"compte" ,"caissier:liste","depot:liste","agence:by:user"})
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"compte","add:compte","caissier:liste","depot:liste","agence:by:user"})
     */
    private $numero;

    /**
     * @ORM\Column(type="integer")
     * @Groups ({"compte","compte:edit","agence:by:user"})
     */
    private $solde = 700000;

    /**
     * @ORM\Column(type="datetime")
     * @Groups ({"compte","agence:by:user"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups ({"compte","compte:edit","caissier:liste"})
     */
    private $statut = 0;

    /**
     * @ORM\ManyToOne(targetEntity=AdminSysteme::class, inversedBy="comptes")
     * @Groups ({"compte","add:compte"})
     */

    private $adminSysteme;
    /**
     * @ORM\OneToOne(targetEntity=Agences::class, inversedBy="comptes", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups ({"compte","add:compte"})
     */
    private $Agence;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archiver= 0;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="compte")
     */
    private $transactions;
    public function __construct()
    {
        $this->createdAt = new  \DateTime();
        $number = date('o') . rand(1000, 9999);
        $this->setNumero($number);
        $this->transactions = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

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

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

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

    public function getAgence(): ?Agences
    {
        return $this->Agence;
    }

    public function setAgence(Agences $Agence): self
    {
        $this->Agence = $Agence;
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
            $transaction->setCompte($this);
        }

        return $this;
    }

    public function removeTransaction(Transactions $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompte() === $this) {
                $transaction->setCompte(null);
            }
        }

        return $this;
    }
}
