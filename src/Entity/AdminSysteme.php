<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdminSystemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminSystemeRepository::class)
 * * @ApiResource(
 *     attributes={"pagination_partial"=true,"pagination_client_items_per_page"=true},
 *     collectionOperations={
 *       "post"=
 *       {
 *          "method"="post",
 *          "path"="/admins",
 *          "attributes"={"security"="is_granted('ROLE_Admin')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"},
 *          "denormalization_context"={"groups"={"admin:add"}},
 *       },
 *       "get"=
 *       {
 *          "method"= "get",
 *          "path"="admins/systeme",
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
 *
 *      },
 * )
 */
class AdminSysteme extends User
{


    /**
     * @ORM\OneToMany(targetEntity=Comptes::class, mappedBy="adminSysteme")
     */
    private $comptes;

    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="adminSysteme")
     */
    private $depots;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->depots = new ArrayCollection();
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

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setAdminSysteme($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getAdminSysteme() === $this) {
                $depot->setAdminSysteme(null);
            }
        }

        return $this;
    }
}
