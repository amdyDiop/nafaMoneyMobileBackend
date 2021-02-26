<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Caissier;
use App\Entity\Comptes;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\AgencesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CaissierDataPersiste implements DataPersisterInterface
{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function supports($data): bool
    {
        return $data instanceof Caissier;
    }
    public function persist($data)
    {
        $this->manager->persist($data);
        $this->manager->flush();
    }
    public function remove($data)
    {
        $data->setArchiver(true);
        $this->manager->flush();
    }
}
