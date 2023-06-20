<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieDetailsController extends AbstractController
{
    #[Route('/movie/details', name: 'app_movie_details')]
    #[Route('/movie/details/{id}', name: 'app_movie_details',  requirements: ['id' => '\d'])]
    public function index(int $id = 1): Response
    {
        $movies = [
            [
                'title' => 'movie1',
                'releasedAt' => new \DateTime('1994-07-01'),
                'genres' => ['action', 'drama']
            ],
            [
                'title' => 'movie2',
                'releasedAt' => new \DateTime('1994-07-01'),
                'genres' => ['action', 'drama']
            ],
            [
                'title' => 'movie3',
                'releasedAt' => new \DateTime('1994-07-01'),
                'genres' => ['action', 'drama']
            ],
            [
                'title' => 'movie4',
                'releasedAt' => new \DateTime('1994-07-01'),
                'genres' => ['action', 'drama']
            ],
            [
                'title' => 'movie5',
                'releasedAt' => new \DateTime('1994-07-01'),
                'genres' => ['action', 'drama']
            ],
            [
                'title' => 'movie6',
                'releasedAt' => new \DateTime('1994-07-01'),
                'genres' => ['action', 'drama']
            ],
            [
                'title' => 'movie7',
                'releasedAt' => new \DateTime('1994-07-01'),
                'genres' => ['action', 'drama']
            ],
            [
                'title' => 'movie8',
                'releasedAt' => new \DateTime('1994-07-01'),
                'genres' => ['action', 'drama']
            ],
            [
                'title' => 'movie9',
                'releasedAt' => new \DateTime('1994-07-01'),
                'genres' => ['action', 'drama']
            ],
        ];

        $movie = $movies[$id - 1] ?? null;

        if (!$movie) {
            throw $this->createNotFoundException('Movie does not exists');
        }

        return $this->render('movie_details/index.html.twig', [
            'movie' => $movie,
            'prev' => $id > 1 ? $id - 1 : null,
            'next' => $id < count($movies) ? $id + 1 : null,
        ]);
    }
}
