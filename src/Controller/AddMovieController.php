<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddMovieController extends AbstractController
{

    public function __construct(MovieRepository $movieRepository) { }

    #[Route('/movie/add', name: 'app_add_movie', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movieRepository->save($movie, true);
            $this->addFlash('success', sprintf('%s a bien été créé', $movie->getTitle()));
            return $this->redirectToRoute('app_movie_details', ['id' => $movie->getId()]);
        }

        return $this->render('add_movie/index.html.twig', [
            'movieForm' => $form,
        ]);
    }
}
