<?php

namespace App\Controller;

use App\Entity\Annonce;
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
        // récupération de Doctrine: permet d'intérargir avec la DB
        $doctrine = $this->getDoctrine();
        // on récupère le "respository" Annonce, qui permet de récupérer des données en DB
        $repository = $doctrine->getRepository(Annonce::class);

        $annonces = $repository->findBy([
            'isSold' => false,
            'status' => [Annonce::STATUS_PERFECT]
        ], [
            'createdAt' => 'DESC'
        ], 3);

        // affiche le fichier index.html.twig
        return $this->render('home/index.html.twig', [
            'annonces' => $annonces
        ]);
    }
}