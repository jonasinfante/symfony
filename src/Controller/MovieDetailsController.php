<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieDetailsController extends AbstractController
{
    #[Route('/movie/details/{id}', name: 'app_movie_details',  requirements: ['id' => '\d+'])]
    public function __invoke(Movie $movie): Response
    {
        return $this->render('movie_details/index.html.twig', [
            'movie' => $movie,
        ]);
    }
}
