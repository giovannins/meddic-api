<?php

namespace App\Controller;

use ErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(Request $request): JsonResponse
    {

        $body = $request->toArray();

        if (!password_verify($body['nkey'], $body['ckey'])) {
            throw new ErrorException("Your key is not valid");
        }

        return $this->json([
            'a' => 'b'
        ]);
    }
}