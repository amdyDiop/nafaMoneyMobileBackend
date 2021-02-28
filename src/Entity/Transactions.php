<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransactionsRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"transactionsComplete"="TransactionsComplete", "transactionsEnCours"="TransactionsEnCours"})
 *
 * @ApiResource(
 *     attributes={"pagination_partial"=true,"pagination_client_items_per_page"=true},
 *     collectionOperations={
 *       "post"=
 *       {
 *          "method"="post",
 *          "path"="/user-agence/transaction/depots",
 *           "denormalization_context"={"groups"={"trans:add"}},
 *       },
 *     },
 *     itemOperations={
 *      "transaction_by_code"=
 *        {
 *          "method"= "get",
 *          "path"="/user-agence/transaction/code",
 *          "security"="is_granted('ROLE_Admin') or is_granted('ROLE_UserAgence')is_granted('ROLE_AdminAgence')",
 *          "security_message"="Vous n'avez pas access à cette Ressource",
 *        },
 *     }
 *
 * )
 */
abstract class Transactions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"transaction"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"trans:add","transaction"})
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     *  @Groups({"transaction"})
     */
    private $date_trans;

    /**
     * @ORM\Column(type="integer")
     *  @Groups({"transaction"})
     */
    private $frais;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais_etat;

    /**
     * @ORM\Column(type="integer")
     *  @Groups({"transaction"})
     */
    private $frais_depot;

    /**
     * @ORM\Column(type="integer")
     *  @Groups({"transaction"})
     */
    private $frais_retrait;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais_systeme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"trans:add","transaction"})
     */
    private $nomCompleteDestination;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"trans:add","transaction"})
     */
    private $cniDestination;

    /**
     * @ORM\Column(type="string", length=14)
     * @Groups({"trans:add","transaction"})
     */
    private $telephoneDestination;

    /**
     * @ORM\ManyToOne(targetEntity=Agences::class, inversedBy="transactions")
     * @Groups({"transaction"})
     */
    private $agenceDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Agences::class, inversedBy="transactions")
     * @Groups({"transaction"})
     */
    private $agenceRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction"})
     */
    private $code;



    public function __construct()
    {
        $this->date_trans = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getDateTrans(): ?\DateTimeInterface
    {
        return $this->date_trans;
    }

    public function setDateTrans(\DateTimeInterface $date_trans): self
    {
        $this->date_trans = $date_trans;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getFraisEtat(): ?int
    {
        return $this->frais_etat;
    }

    public function setFraisEtat(int $frais_etat): self
    {
        $this->frais_etat = $frais_etat;

        return $this;
    }

    public function getFraisDepot(): ?int
    {
        return $this->frais_depot;
    }

    public function setFraisDepot(int $frais_depot): self
    {
        $this->frais_depot = $frais_depot;

        return $this;
    }

    public function getFraisRetrait(): ?int
    {
        return $this->frais_retrait;
    }

    public function setFraisRetrait(int $frais_retrait): self
    {
        $this->frais_retrait = $frais_retrait;

        return $this;
    }

    public function getFraisSysteme(): ?int
    {
        return $this->frais_systeme;
    }

    public function setFraisSysteme(int $frais_systeme): self
    {
        $this->frais_systeme = $frais_systeme;

        return $this;
    }




    public function getNomCompleteDestination(): ?string
    {
        return $this->nomCompleteDestination;
    }

    public function setNomCompleteDestination(string $nomCompleteDestination): self
    {
        $this->nomCompleteDestination = $nomCompleteDestination;

        return $this;
    }

    public function getCniDestination(): ?string
    {
        return $this->cniDestination;
    }

    public function setCniDestination(string $cniDestination): self
    {
        $this->cniDestination = $cniDestination;

        return $this;
    }

    public function getTelephoneDestination(): ?string
    {
        return $this->telephoneDestination;
    }

    public function setTelephoneDestination(string $telephoneDestination): self
    {
        $this->telephoneDestination = $telephoneDestination;

        return $this;
    }

    public function getAgenceDepot(): ?Agences
    {
        return $this->agenceDepot;
    }

    public function setAgenceDepot(?Agences $agenceDepot): self
    {
        $this->agenceDepot = $agenceDepot;

        return $this;
    }

    public function getAgenceRetrait(): ?Agences
    {
        return $this->agenceRetrait;
    }

    public function setAgenceRetrait(?Agences $agenceRetrait): self
    {
        $this->agenceRetrait = $agenceRetrait;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }


}
