<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonces", name="annonce")
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {       
        //recherche par ID
        $annonce = $annonceRepository->find(1);

        // recherche toutes les annonces
        $annonce = $annonceRepository->findAll();

        // rechercher une annonce par champ
        $annonce = $annonceRepository->findOneBy(['sold' => false]);

        // recherche par non vendu
        $annonces = $annonceRepository->findAllNotSold();

        dump($annonce);
        dump($annonces);

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    /**
     * @Route("/annonces/new")
     */
    public function new()
    {
        $annonce = new Annonce();
        $annonce
            ->setTitle('Sabre lazer peu utilisé')
            ->setDescription('Couleur bleu, très coupant. Il peut aussi vous tenir chaud en hiver.')
            ->setPrice(8000)
            ->setStatus(Annonce::STATUS_BAD)
            ->setSold(false);

            // on utilise EntityManager pour inserer notre nouvelle entité
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            // et on envoie
            $em->flush();

            die('Annonce créée');
    }

    /**
     * @Route("/annonces/{id}", requirements={"id": "\d+"})
     * @return Response
     */
    public function show(int $id, AnnonceRepository $annonceRepository): Response
    {
        $annonce = $annonceRepository->find($id);

        if(!$annonce) {
            throw $this->createNotFoundException();
        }
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }
}
