<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\TransactionsEnCours;
use App\Repository\ComptesRepository;
use App\Repository\TransactionsCompleteRepository;
use App\Repository\TransactionsEnCoursRepository;
use App\services\FraisServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TransactionController extends AbstractController
{
    private $enCoursRep;
    private $completeRep;
    private $serializer;

    public function __construct(SerializerInterface $serializer, TransactionsEnCoursRepository $enCoursRep, TransactionsCompleteRepository $completeRep)
    {
        $this->enCoursRep = $enCoursRep;
        $this->completeRep = $completeRep;
        $this->serializer = $serializer;
    }

    /**
     * @Route(path={"/api/user-agence/transaction/depots"},methods={"POST"})
     */
    public function transaction(EntityManagerInterface $manager, ComptesRepository $compteRep, FraisServices $fraisServices, SerializerInterface $serializer, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $client = new Clients();
        $transaction = new TransactionsEnCours();
        $client = new Clients();
        $agence = $this->getUser()->getAgences();
        $compte = $agence->getComptes();
        $solde = $compte->getSolde();
        $fraisServices->makeFrais($data['Montant'], $transaction);
        if ($solde >= ($data['Montant'] + $transaction->getFrais())) {
            foreach ($data as $key => $value) {
                $set = "set" . $key;
                if ($key == "NomComplet" || $key == "Cni" || $key == "Telephone") {
                    $client->$set($value);
                } else {
                    $transaction->$set($value);
                }
            }
            $transaction->setAgenceDepot($agence);
            $restant = $solde - ($data['Montant'] + $transaction->getFrais());
            //dd($wagni);
            //retrait du montant de depot et ajout frais dans sole compte de
            $compte->setSolde($restant);
            $client->setCni($data['Cni']);
            $client->setNomComplet($data['NomComplet']);
            $client->setTelephone($data['Telephone']);
            $code = rand(100, 999) . rand(100, 999) . rand(100, 999) . rand(100, 999);
            $transaction->setCode($code);
            $manager->persist($compte);
            $manager->persist($transaction);
            $manager->persist($client);
            $manager->flush();
            return new JsonResponse('vous avez envoyé' . $data['Montant'] . " à " . $data['NomCompleteDestination'], Response::HTTP_BAD_REQUEST, [], false);
        } else {
            return new JsonResponse('fall li nga yore matoule', Response::HTTP_BAD_REQUEST, [], false);
        }
        // $transaction = $serializer->deserialize($data,TransactionsEnCours::class,true,['groups'=>'trans:add']);
    }

    /**
     * @Route(path={"/api/user-agence/transaction/code"},methods={"get"})
     */
    public function findTransaction(SerializerInterface $serializer, Request $request): Response
    {
        $code = json_decode($request->getContent(), true);
        $transaction = $this->enCoursRep->findBy(['code' => $code]);
        if ($transaction) {
            $transactionJson = $serializer->serialize($transaction[0], 'json', ["groups" => "transaction"]);
            $transactionJson = json_decode($transactionJson);
            return new JsonResponse($transactionJson, Response::HTTP_OK, [], false);
        } else {
            $transaction = $this->completeRep->findBy(['code' => $code]);
            if ($transaction) {
                $transactionJson = $serializer->serialize($transaction[0], 'json', ["groups" => "transaction"]);
                $transactionJson = json_decode($transactionJson);
                return new JsonResponse($transactionJson, Response::HTTP_OK, [], false);
            } else {
                return new JsonResponse('code invalide', Response::HTTP_OK, [], false);
            }
        }
    }
    /**
     * @Route(path={"/api/user-agence/transaction/{id}retrait"},methods={"get"})
     */
    public function retrait(TransactionsEnCours $transaction, SerializerInterface $serializer, Request $request): Response
    {
        dd('sdgbdsg', $transaction);
        if ($transaction) {
            $transactionJson = $serializer->serialize($transaction[0], 'json', ["groups" => "transaction"]);
            $transactionJson = json_decode($transactionJson);
            return new JsonResponse($transactionJson, Response::HTTP_OK, [], false);
        } else {
            $transaction = $this->completeRep->findBy(['code' => $code]);
            if ($transaction) {
                $transactionJson = $serializer->serialize($transaction[0], 'json', ["groups" => "transaction"]);
                $transactionJson = json_decode($transactionJson);
                return new JsonResponse($transactionJson, Response::HTTP_OK, [], false);
            } else {
                return new JsonResponse('code invalide', Response::HTTP_OK, [], false);
            }
        }
    }

}
