<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CaissierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CaissierRepository::class)
 * @ApiResource(
 *     attributes={"pagination_partial"=true,"pagination_client_items_per_page"=true},
 *     collectionOperations={
 *       "post"=
 *       {
 *          "method"="post",
 *          "path"="/admin/caissiers",
 *          "attributes"={"security"="is_granted('ROLE_Admin')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"},
 *          "denormalization_context"={"groups"={"add:caissier"}},
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
class Caissier extends User
{


    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="caissier")
     * @Groups({"caissier:liste"})
     */
    private $depots;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->depots = new ArrayCollection();
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
            $depot->setCaissier($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getCaissier() === $this) {
                $depot->setCaissier(null);
            }
        }

        return $this;
    }

}
