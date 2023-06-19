<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    #[Route('/hello/{name}', name: 'app_hello')]
    public function __invoke(Request $request, ?string $name = null): JsonResponse
    {
        $message = sprintf('Hello %s', $name ?? $request->get('name'));

        return $this->json([
            'message' => $message,
            'path' => 'src/Controller/HomepageController.php',
        ]);
    }
}
