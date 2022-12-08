<?php

namespace App\Controller;

use App\Entity\Score;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use ErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'users_all', methods: ['GET'])]
    public function index(Request $request, UserRepository $userRepository): JsonResponse
    {

        $body = $request->toArray();

        if (!password_verify($body['nkey'], $body['ckey'])) {
            throw new ErrorException("Your key is not valid");
        }

        $data = $userRepository->findAll();

        return $this->json(['data' => $data]);
    }

    #[Route('/users/{id}', name: 'users_id', methods: ['GET'])]
    public function getId(Request $request, UserRepository $userRepository, int $id): JsonResponse
    {

        $body = $request->toArray();

        if (!password_verify($body['nkey'], $body['ckey'])) {
            throw new ErrorException("Your key is not valid");
        }

        return $this->json($userRepository->find($id));
    }

    #[Route('/users/name/{name}', name: 'users_name', methods: ['GET'])]
    public function getUserName(Request $request, UserRepository $userRepository, string $name): JsonResponse
    {

        $body = $request->toArray();

        if (!password_verify($body['nkey'], $body['ckey'])) {
            throw new ErrorException("Your key is not valid");
        }

        return $this->json($userRepository->findOneBy(['name' => $name]));
    }

    #[Route('/users', name: 'users_name_add', methods: ['POST'])]
    public function addUser(Request $request, ManagerRegistry $managerRegistry): JsonResponse
    {
        $body = $request->toArray();

        if (!password_verify($body['nkey'], $body['ckey'])) {
            throw new ErrorException("Your key is not valid");
        }
        
        $manager = $managerRegistry->getManager();

        $user = new User();
        $user->setName($body['name']);
        $user->setEmail($body['email']);
        $user->setKey('key');
        $user->setPassword(password_hash($body['password'], PASSWORD_BCRYPT));
        $user->setManager($body['manager']);
        
        $manager->persist($user);
        $manager->flush();

        return $this->json($user->getId());
    }
}