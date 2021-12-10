<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        // affiche le fichier index.html.twig
        return $this->render('home/index.html.twig', [
            'date' => new DateTime(),
            'content' => 'Lorem ipsum...',
            'title' => 'Bienvenue sur le MetaVerse !',
            'data' => ['Annonce 1', 'Annonce 2', 'Annonce 3', 'Annonce 4']
        ]);
    }
}