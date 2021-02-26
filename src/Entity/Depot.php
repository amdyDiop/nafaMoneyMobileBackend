<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DepotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
 *          "path"="admin/caissiers",
 *          "normalization_context"={"groups"={"caissier:liste"}},
 *      "attributes"={"security"="is_granted('ROLE_Admin')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"},
 *       },
 *     },
 *     itemOperations={
 *          "get"=
 *              {
 *                "methode"="get",
 *                "path"="caissier/{id}",
 *                "security"="is_granted('ROLE_Admin') or object.getId() == user.id",
 *                "security_message"="Vous n'avez pas access à cette Ressource",
 *                 "normalization_context"={"groups"={"caissier"}},
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
     * @Groups({"caissier:liste"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Caissier::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=true)
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

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="integer")
     * @Groups({"depot:add"})
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
