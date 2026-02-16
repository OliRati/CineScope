<?php

namespace App\Controller;

use App\Entity\Platforme;
use App\Repository\FilmRepository;
use App\Repository\PlatformeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlatformeController extends AbstractController
{
    #[Route('/platformes', name: 'app_platforme_index')]
    public function index(PlatformeRepository $platformeRepository): Response
    {
        return $this->render('platforme/index.html.twig', [
            'platformes' => $platformeRepository->findAll(),
        ]);
    }

    #[Route('/platformes/{id}', name: 'app_platforme_show')]
    public function show(Platforme $platforme): Response
    {
        return $this->render('platforme/show.html.twig', [
            'platforme' => $platforme,
            'films' => $platforme->getFilms(),
        ]);
    }
}
