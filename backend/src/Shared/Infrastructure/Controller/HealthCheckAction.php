<?php

namespace App\Shared\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\{JsonResponse, Response};
use Symfony\Component\Routing\Annotation\Route;

#[Route('/health-check', name: 'health_check', methods: ['GET'])]
class HealthCheckAction
{
    public function __invoke(): Response
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
