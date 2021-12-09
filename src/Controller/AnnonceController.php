<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(): Response
    {
        return $this->render('annonce/index.html.twig', [
            'controller_name' => 'AnnonceController',
        ]);
    }

    /**
     * @Route("/annonce/{id<\d+>}", methods={"GET"})
     *
     * @return void
     */
    public function annonceById(int $id)
    {
        die('détail d\'une annonce avec id ' . $id);
    }

    /**
     * @Route("/annonce/{slug<^[a-z0-9]+(?:-[a-z0-9]+)*$>}", methods={"GET"})
     */
    public function annonceBySlug($slug)
    {
        die('annonce avec slug ' . $slug);
    }

    /**
     * @Route("/annonce/{month<0[1-9]|1[0-2]>}-{year<\d{4}>}", methods={"GET"})
     *
     * @param integer $month
     * @param integer $year
     * @return void
     */
    public function annonceByDate(int $month, int $year)
    {
        die('annonce avec mois: ' . $month . ' et année ' . $year);
    }
}
