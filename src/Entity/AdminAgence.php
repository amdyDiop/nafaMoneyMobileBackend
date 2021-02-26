<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdminAgenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AdminAgenceRepository::class)
 *  @ApiResource(
 *     attributes={"pagination_partial"=true,"pagination_client_items_per_page"=true},
 *     collectionOperations={
 *       "post"=
 *       {
 *          "method"="post",
 *          "path"="/admin-agence/add",
 *          "attributes"={"security"="is_granted('ROLE_Admin')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"},
 *          "denormalization_context"={"groups"={"adminAg:add"}},
 *       },
 *      "get"=
 *       {
 *          "method"= "get",
 *          "path"="/admin-agences",
 *          "attributes"={"security"="is_granted('ROLE_Admin')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"},
 *       },
 *     },
 *     itemOperations={
 *      "get"=
 *        {
 *          "method"= "get",
 *          "path"="/admin-agence/{id}",
 *          "attributes"={"security"="is_granted('ROLE_Admin')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"},
 *        },
 *     }
 *
 * )
 */
class AdminAgence extends User
{

    /**
     * @ORM\OneToOne(targetEntity=Agences::class, mappedBy="adminAgence", cascade={"persist", "remove"})
     * @Groups ({"adminAg:add"})
     */
    private $agences;

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
