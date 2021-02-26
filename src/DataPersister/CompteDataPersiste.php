<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Comptes;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\AgencesRepository;
use App\Repository\ComptesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class CompteDataPersiste implements DataPersisterInterface
{

    private $manager;
    private $agenceRep;
    private $compteRep;
    private $securrity;

    public function __construct(Security $security,AgencesRepository $agenceRep,ComptesRepository  $compteRep, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->securrity = $security;
        $this->agenceRep = $agenceRep;
        $this->compteRep = $compteRep;
    }

    public function supports($data): bool
    {
        return $data instanceof Comptes;
    }

    public function persist($data)
    {
        if ($data->getId() == null){
            $user = $this->securrity->getUser();
            $data->setAdminSysteme($user);
        }
        $this->manager->persist($data);
        $this->manager->flush();
    }
    public function remove($data)
    {
        $data->setArchiver(true);
        $data->getAgence()->setArchiver(true);
        $idAgence = $data->getAgence()->getId();
        $agence = $this->agenceRep->find($idAgence);
        $this->manager->flush();
    }
}
