<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/me")
     */
    public function me(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    /**
     * @Route("/annonce")
     */
    public function annonce(): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $this->getUser()->getAnnonces()
        ]);
    }
}
