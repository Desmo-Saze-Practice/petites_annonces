<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $lastThreeAnnonces = $annonceRepository->findLastNotSold();

        $title = 'How to dominate the world in three steps';
        return $this->render('home/index.html.twig', [
            'lastThreeAnnonces' => $lastThreeAnnonces,
            'title' => $title,
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem quam cum corrupti modi cupiditate nostrum odit illo veniam, nulla neque officia expedita rerum, aliquid libero incidunt rem iusto reprehenderit maxime!',
            'date' => new \DateTime(),
            'current_annonce' => "app_annonce_index",
        ]);
    }
}
