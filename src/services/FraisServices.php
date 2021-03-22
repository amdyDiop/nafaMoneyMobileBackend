<?php


namespace App\services;


use App\Repository\FraisRepository;

class FraisServices
{
    private $FraisRep;

    public function __construct(FraisRepository $FraisRep)
    {
        $this->FraisRep = $FraisRep;
    }

    function calculFrais(int $montant)
    {
        $frais = $this->FraisRep->findAll();
        foreach ($frais as  $value) {
            if ($montant <= $value->getMontant()) {
                return $value->getFrais();
            }
        }
        return $montant * 2 / 100;
    }

    function makeFrais($montant,$entity){
        $entity->setFraisEtat($this->calculFrais($montant)*40/100);
        $entity->setFrais($this->calculFrais($montant));
        $entity->setFraisDepot($this->calculFrais($montant)*10/100);
        $entity->setFraisSysteme($this->calculFrais($montant)*30/100);
        $entity->setFraisRetrait($this->calculFrais($montant)*20/100);
    }
}
