<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DepotRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DepotRepository::class)
 * @ApiResource(
 *     attributes={"pagination_partial"=true,"pagination_client_items_per_page"=true},
 *     collectionOperations={
 *       "post"=
 *       {
 *          "method"="post",
 *          "path"="/depots/compte/{id}",
 *          "attributes"={"security"="is_granted('ROLE_Admin') or is_granted('ROLE_Caissier')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"},
 *          "denormalization_context"={"groups"={"depot:add"}},
 *       },
 *       "get"=
 *       {
 *          "method"= "get",
 *          "path"="admin/depots",
 *          "normalization_context"={"groups"={"depot:liste"}},
 *          "attributes"={"security"="is_granted('ROLE_Admin')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"},
 *       },
 *     },
 *     itemOperations={
 *          "get"=
 *              {
 *                "methode"="get",
 *                "path"="admin/depot/{id}",
 *                "security"="is_granted('ROLE_Admin')",
 *                "security_message"="Vous n'avez pas access à cette Ressource",
 *                 "normalization_context"={"groups"={"depot:liste"}},
 *                },
 *              "put"=
 *              {
 *                "methode"="put",
 *                "path"="admin/caissier/{id}",
 *                "security"="is_granted('ROLE_Admin')",
 *                "security_message"="Vous n'avez pas access à cette Ressource",
 *                "denormalization_context"={"groups"={"edit:caissier"}},
 *                },
 *             "delete"=
 *               {
 *                "methode"="delete",
 *                "path"="admin/caissier/{id}",
 *                "security"="is_granted('ROLE_Admin')",
 *                "security_message"="Vous n'avez pas access à cette Ressource",
 *                },
 *      },
 * )
 */
class Depot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"caissier:liste","depot:liste"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Caissier::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"depot:liste"})
     */
    private $caissier;

    /**
     * @ORM\ManyToOne(targetEntity=Comptes::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"depot:liste"})
     *
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity=AdminSysteme::class, inversedBy="depots")
     * @Groups({"depot:liste"})
     */
    private $adminSysteme;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"depot:liste"})
     */
    private $createdAt;
    /**
     * @ORM\Column(type="integer")
     * @Groups({"depot:add"})
     * @Groups({"depot:liste"})
     */
    private $montant;

    public function __construct()
    {
        $this->createdAt = new  \DateTime();
    }

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
