<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Comptes;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\AgencesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CompteDataPersiste implements DataPersisterInterface
{

    private $manager;
    private $agenceRep;

    public function __construct(AgencesRepository $agenceRep, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->agenceRep = $agenceRep;
    }

    public function supports($data): bool
    {
        return $data instanceof Comptes;
    }

    public function persist($data)
    {
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
