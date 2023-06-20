<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListMovieController extends AbstractController
{
    #[Route('/movie/list', name: 'app_movie_list')]
    public function __invoke(MovieRepository $movieRepository): Response
    {
        return $this->render('list_movie/index.html.twig', [
            'movies' => $movieRepository->findAll(),
        ]);
    }
}
