<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\AdminAgence;
use App\Entity\AdminSysteme;
use App\Entity\Caissier;
use App\Entity\Comptes;
use App\Entity\Profil;
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

class UserAgenceDataPersiste implements DataPersisterInterface
{

    private $manager;
    private $security;
    private $encoder;
    private $profilRep;
    private $agenceRep;
    private $admsRep;

    public function __construct(AdminSystemeRepository $admsRep, Security $security, AgencesRepository $agenceRep, ProfilRepository $profilRep, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->profilRep = $profilRep;
        $this->agenceRep = $agenceRep;
        $this->admsRep = $admsRep;
        $this->encoder = $encoder;
        $this->security = $security;
    }
    public function supports($data): bool
    {
        return $data instanceof UserAgence;
    }
    public function persist($data)
    {
        $user = $this->security->getUser();
        if ($user instanceof AdminAgence) {
            $agenceId = $user->getAgences()->getId();
            if ($data->getAgences()->getId() == $agenceId) {
                $data->setPassword($this->encoder->encodePassword($data, "password"));
                $profil = $this->profilRep->findBy(['libelle' => "UserAgence"]);
                $data->setProfil($profil[0]);
                $this->manager->persist($data);
                $this->manager->flush();
                return new JsonResponse("un  utilisateur  de  l'agence a été crée", Response::HTTP_CREATED, []);
            } else {
                return new JsonResponse("vous ete pas autorisé a créer uun user agence dans cette agence", Response::HTTP_CREATED, []);
            }

        } else {
            $data->setPassword($this->encoder->encodePassword($data, "password"));
            $profil = $this->profilRep->findBy(['libelle' => "UserAgence"]);
            $data->setProfil($profil[0]);
            $this->manager->persist($data);
            $this->manager->flush();
            return new JsonResponse("un  utilisateur  de  l'agence a été crée", Response::HTTP_CREATED, []);
        }
    }

    public function remove($data)
    {
        $user = $this->security->getUser();
        if ($user instanceof AdminAgence) {
            $agenceId = $user->getAgences()->getId();
            if ($data->getAgences()->getId() == $agenceId) {
                $data->setArchiver(true);
                $this->manager->flush();
                return new JsonResponse("  utilisateur a été bloqué de l'agence", Response::HTTP_CREATED, []);
            } else {
                return new JsonResponse("vous n'ete pas autorisé a bloquée cette utilisateur", Response::HTTP_CREATED, []);
            }
        } else {
            $data->setArchiver(true);
            $this->manager->flush();
            return new JsonResponse("  utilisateur a été bloqué de l'agence", Response::HTTP_CREATED, []);
        }

    }
}
