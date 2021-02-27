<?php

namespace App\Controller;

use App\Entity\AdminSysteme;
use App\Entity\Comptes;
use App\Entity\Depot;
use App\Repository\AdminSystemeRepository;
use App\Repository\CaissierRepository;
use App\Repository\ComptesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepotController extends AbstractController
{
    private $compteRep;
    private $adminSystemeRep;
    private $caissierRep;
    private $manager;

    public function __construct(CaissierRepository $caissierRep, AdminSystemeRepository $adminSystemeRep, EntityManagerInterface $manager, ComptesRepository $compteRep)
    {
        $this->compteRep = $compteRep;
        $this->caissierRep = $caissierRep;
        $this->adminSystemeRep = $adminSystemeRep;
        $this->manager = $manager;
    }
    /**
     * @Route(path={"/api/depots/compte/{id}"},methods={"POST"})
     */
    public function depot(int $id ,Request  $request): Response
    {
        $compte = $this->compteRep->find($id);
        $depot = new Depot();
        $data = json_decode($request->getContent(),true);
        $depot->setMontant($data['montant']);
        if ($compte) {
            $user = $this->getUser();
            $username = $user->getUsername();
            if ($user instanceof AdminSysteme) {
                $user = $this->adminSystemeRep->findBy(['email' => $username]);
                $depot->setAdminSysteme($user[0]);
            } else {
                $user =$this->adminSystemeRep->findBy(['email'=>$username]);
                $depot->setAdminSysteme($user[0]);
            }
            $solde = $depot->getMontant() + $compte->getSolde();
            $compte->setSolde($solde);
            $depot->setCompte($compte);
        }
        else {
            return new JsonResponse("le compte avec l'id: $id n'existe pas", Response::HTTP_BAD_REQUEST, []);
        }
        $this->manager->persist($depot);
        $this->manager->flush();
        return new JsonResponse($data['montant']." a été déposé sur le compte" , Response::HTTP_CREATED, []);
    }
}
