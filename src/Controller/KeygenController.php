<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class KeygenController extends AbstractController
{
    #[Route('/keygen', name: 'app_keygen')]
    public function index(): JsonResponse
    {
        $rng = rand(1000, 9999);
        $key = password_hash($rng, PASSWORD_BCRYPT);
        return $this->json([
            'nkey' => $rng,
            'ckey' => $key,
        ]);
    }
}
