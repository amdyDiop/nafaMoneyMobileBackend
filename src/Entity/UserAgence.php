<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserAgenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserAgenceRepository::class)
 *  @ApiResource(
 *     attributes={"pagination_partial"=true,"pagination_client_items_per_page"=true},
 *     collectionOperations={
 *       "post"=
 *       {
 *          "method"="post",
 *          "path"="/admin-agence/user-agence/add",
 *          "security"="is_granted('ROLE_Admin') or is_granted('ROLE_AdminAgence')  ",
 *          "security_message"="Vous n'avez pas access à cette Ressource",
 *          "denormalization_context"={"groups"={"adminAg:add"}},
 *       },
 *       "get"=
 *       {
 *          "method"= "get",
 *          "path"="/admin-agence/users-agence/list",
 *          "security"="is_granted('ROLE_Admin') ",
 *          "security_message"="Vous n'avez pas access à cette Ressource",
 *       },
 *     },
 *     itemOperations={
 *          "get"=
 *              {
 *                "methode"="get",
 *                "path"="admin-agence/user-agence/{id}",
 *                "security"="is_granted('ROLE_Admin') or is_granted('ROLE_AdminAgence')",
 *                "security_message"="Vous n'avez pas access à cette Ressource",
 *                },
 *              "delete"=
 *              {
 *                "methode"="delete",
 *                "path"="admin-agence/user-agence/{id}",
 *                "security"="is_granted('ROLE_Admin') or is_granted('ROLE_AdminAgence')",
 *                "security_message"="Vous n'avez pas access à cette Ressource",
 *                },
 *
 *      },
 * )
 */
class UserAgence extends User
{

    /**
     * @ORM\ManyToOne(targetEntity=Agences::class, inversedBy="userAgence")
     * @Groups ({"adminAg:add"})
     */
    private $agences;


    public function getAgences(): ?Agences
    {
        return $this->agences;
    }

    public function setAgences(?Agences $agences): self
    {
        $this->agences = $agences;

        return $this;
    }
}
