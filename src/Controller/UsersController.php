<?php

namespace App\Controller;

use App\Repository\UserRepository;
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

        return $this->json($userRepository->findAll());
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
}