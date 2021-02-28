<?php


namespace App\services;


class FraisServices
{
    function calculFrais(int $montant, $entity)
    {
        switch ($montant) {
            case ($montant <= 5000):$frais = 425;break;
            case ($montant <= 10000):$frais = 850;break;
            case ($montant <= 15000):$frais = 1270;break;
            case ($montant <= 20000):$frais = 1695;break;
            case ($montant <= 50000):$frais = 2500;break;
            case ($montant <= 60000):$frais = 3000;break;
            case ($montant <= 75000):$frais = 4000;break;
            case ($montant <= 125000):$frais = 5000;break;
            case ($montant <= 150000):$frais = 6000;break;
            case ($montant <= 200000):$frais = 7000;break;
            case ($montant <= 250000):$frais = 8000;break;
            case ($montant <= 300000):$frais = 9000;break;
            case ($montant <= 400000):$frais = 12000;break;
            case ($montant <= 750000):$frais = 15000;break;
            case ($montant <= 900000):$frais = 22000;break;
            case ($montant <= 1000000):$frais = 25000;break;
            case ($montant <= 1125000):$frais = 27000;break;
            case ($montant<=1400000):$frais = 30000;break;
            default:$frais = $montant *2 /100 ;break;
        }
        $entity->setFrais($frais);
        $entity->setFraisEtat($frais*40/100);
        $entity->setFraisDepot($frais/10);
        $entity->setFraisRetrait($frais*2/10);
        $entity->setFraisSysteme($frais*3/10);


    }
}
