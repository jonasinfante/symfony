<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieDetailsController extends AbstractController
{
    #[Route('/movie/details/{id}', name: 'app_movie_details',  requirements: ['id' => '\d+'])]
    public function __invoke(MovieRepository $movieRepository, int $id): Response
    {
        $movie = $movieRepository->findOneBy(['id' => $id]);

        if (!$movie) {
            throw $this->createNotFoundException('Movie does not exists');
        }

        return $this->render('movie_details/index.html.twig', [
            'movie' => $movie,
        ]);
    }
}
