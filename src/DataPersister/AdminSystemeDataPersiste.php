<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\AdminSysteme;
use App\Entity\Caissier;
use App\Entity\Comptes;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\AgencesRepository;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminSystemeDataPersiste implements DataPersisterInterface
{

    private $manager;
    private  $encoder;
    private  $profilRep;

    public function __construct(ProfilRepository  $profilRep,UserPasswordEncoderInterface $encoder,EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->profilRep = $profilRep;
        $this->encoder = $encoder;
    }

    public function supports($data): bool
    {
        return $data instanceof AdminSysteme;
    }
    public function persist($data)
    {
        $data->setPassword($this->encoder->encodePassword($data, "password"));
        $profil = $this->profilRep->findBy(['libelle' => "Admin"]);
        $data->setProfil($profil[0]);
        $this->manager->persist($data);
        $this->manager->flush();
        return;
    }
    public function remove($data)
    {
        $data->setArchiver(true);
        $this->manager->flush();
    }
}
