<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AgencesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("api/auth/current_user", name="current_user",methods={"GET"})
     */
    public function index(UserRepository $repository, AgencesRepository $agencesRep): Response
    {
        $telephone = $this->getUser()->getUsername();
        $user = $repository->findBy(['telephone' => $telephone]);
        return $this->json($user[0], Response::HTTP_OK, [], ["groups" => "user:read"]);
    }

    /**
     * @Route("api/agence-by-user", name="agence-by-user",methods={"GET"})
     */
    public function AgenceByUser(AgencesRepository $agencesRep): Response
    {
        $telephone = $this->getUser()->getUsername();
        $user = $agencesRep->findByUser($telephone);
        return $this->json($user[0], Response::HTTP_OK, [], ["groups" => "agence:by:user"]);
    }
}
