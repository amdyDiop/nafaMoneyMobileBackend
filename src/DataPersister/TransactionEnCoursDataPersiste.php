<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\AdminAgence;
use App\Entity\AdminSysteme;
use App\Entity\Caissier;
use App\Entity\Comptes;
use App\Entity\Profil;
use App\Entity\Transactions;
use App\Entity\TransactionsComplete;
use App\Entity\TransactionsEnCours;
use App\Entity\User;
use App\Entity\UserAgence;
use App\Repository\AdminSystemeRepository;
use App\Repository\AgencesRepository;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

class TransactionEnCoursDataPersiste implements DataPersisterInterface
{

    private $manager;
    private $serializer;
    private $security;
    private $encoder;
    private $agenceRep;

    public function __construct(SerializerInterface $serializer, Security $security, AgencesRepository $agenceRep, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->agenceRep = $agenceRep;
        $this->encoder = $encoder;
        $this->serializer = $serializer;
        $this->security = $security;
    }

    public function supports($data): bool
    {
        return $data instanceof TransactionsEnCours;
    }

    public function persist($data)
    {
        $this->manager->persist($data);
        $this->manager->flush();
    }

    public function remove($data)
    {
        $user = $this->security->getUser();
        $agence = $user->getAgences();
        $compte = $user->getAgences()->getComptes();
        $montant = $compte->getSolde() + $data->getMontant() +$data->getFraisRetrait();
        $compte->setSolde($montant);
        $transComp = new TransactionsComplete();
        $transComp->setAgenceRetrait($agence);
        $transComp->setCode($data->getCode());
        $transComp->setMontant($data->getMontant());
        $transComp->setAgenceDepot($data->getAgenceDepot());
        $transComp->setMontant($data->getMontant());
        $transComp->setFrais($data->getFrais());
        $transComp->setFraisEtat($data->getFraisEtat());
        $transComp->setFraisDepot($data->getFraisDepot());
        $transComp->setFraisRetrait($data->getFraisRetrait());
        $transComp->setFraisSysteme($data->getFraisSysteme());
        $transComp->setNomCompleteDestination($data->getNomCompleteDestination());
        $transComp->setCniDestination($data->getCniDestination());
        $transComp->setTelephoneDestination($data->getTelephoneDestination());
        $this->manager->persist($compte);
        $this->manager->persist($transComp);
        $this->manager->remove($data);
        $this->manager->flush();
    }
}
