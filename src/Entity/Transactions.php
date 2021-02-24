<?php

namespace App\Entity;

use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionsRepository::class)
 */
class Transactions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_trans;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais_etat;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais_depot;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais_retrait;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais_systeme;

    /**
     * @ORM\ManyToOne(targetEntity=TransactionsEnCours::class)
     */
    private $enCours;

    /**
     * @ORM\ManyToOne(targetEntity=TransactionsComplete::class)
     */
    private $complete;

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

    public function getEnCours(): ?TransactionsEnCours
    {
        return $this->enCours;
    }

    public function setEnCours(?TransactionsEnCours $enCours): self
    {
        $this->enCours = $enCours;

        return $this;
    }

    public function getComplete(): ?TransactionsComplete
    {
        return $this->complete;
    }

    public function setComplete(?TransactionsComplete $complete): self
    {
        $this->complete = $complete;

        return $this;
    }
}
