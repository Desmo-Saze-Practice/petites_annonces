<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about")
     */
    public function index()
    {
        // des données qui pourraient
        // provenir de la bdd
        $data = ['Lorem', 'ipsum', 'dolor', 'sit'];

        return $this->render('about/index.html.twig', [
            'title' => 'About',
            'data' => $data
        ]);
    }
}