<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DeleteMovieController extends AbstractController
{
    public function __construct(
        protected readonly MovieRepository $movieRepository
    ) { }

    #[Route('/movie/delete/{id}', name: 'app_movie_delete',  requirements: ['id' => '\d+'])]
    #[IsGranted('delete', 'movie')]
    public function index(Movie $movie): Response
    {
        $this->movieRepository->remove($movie, true);

        $this->addFlash('success', sprintf('%s a été supprimé', $movie->getTitle()));

        return $this->redirectToRoute('app_movie_list');
    }
}
