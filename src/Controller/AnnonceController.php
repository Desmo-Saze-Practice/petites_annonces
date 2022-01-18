<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        // on récupère le service Doctrine
        //$doctrine = $this->getDoctrine();
        // on récupère le "respository" Annonce, qui permet de récupérer des données en DB
        //$annonceRepository = $doctrine->getRepository(Annonce::class); // = 'App\Entity\Annonce'
        // on récupère toutes les annonces grâce au repository
        //$annonces = $annonceRepository->findAll();
        
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findBy([
                'isSold' => false
            ]),
        ]);
    }

    /**
     * @Route("/annonce/{id<\d+>}", methods={"GET"})
     *
     * @return void
     */
    public function annonceById(Annonce $annonce)
    {
        /*$annonce = $this->getDoctrine()->getRepository(Annonce::class)->find($id);

        if(!$annonce) {
            throw $this->createNotFoundException();
        }*/

        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce
        ]);
    }

    /**
     * @Route("/annonce/new")
     */
    public function new(Request $request, EntityManagerInterface $em)
    {
        $annonce = new Annonce();
        // on créer un formulaire
        $form = $this->createForm(
            AnnonceType::class, // on cherche le type (la classe où on construit le formulaire)
            $annonce // on met les données de $annonce dans le formulaire
        );

        // écoute la requête courante
        $form->handleRequest($request);

        if ($form->isSubmitted()) { // quand le formulaire est envoyé
            // $em = $this->getDoctrine()->getManager(); sans l'$annonceRepository
            $em->persist($annonce);            
            $em->flush();
            return $this->redirectToRoute('app_annonce_annoncebyslug', ['slug' => $annonce->getSlug()]);
        }

        return $this->render('annonce/new.html.twig', [
            'form' => $form->createView()
        ]);
        
        // ne pas oublier use App\Entity\Annonce; en haut du fichier
        /*$annonce = new Annonce();
        $title = 'Ma collection de canard en NFT snvdjn';
        $annonce
            ->setTitle($title)
            ->setDescription('Vends car j\'ai envie de spéculer')
            ->setStatus(Annonce::STATUS_PERFECT)
            ->setPrice(100)
            ->setIsSold(false)
        ;

        dump($annonce);

        // on demande le service Doctrine grâce à extend AbstractController
        $doctrine = $this->getDoctrine();
        // on demande à Doctrine le Manager d'Entité
        // c'est grâce à lui qu'on peut lancer des requêtes SQL
        $entityManager = $doctrine->getManager();
        // on prépare, on construit la requête en "persistant" une entité
        // c'est que pour les données qui ne sont pas en base de donnée
        $entityManager->persist($annonce);
        // on envoie (en SQL c'est un commit) tous ce qui est persisté en base de données
        $entityManager->flush();

        dump($annonce);*/
        
        die('nouvelle annonce');
    }

    /**
     * @Route("/annonce/search", methods={"GET"})
     */
    public function search(Request $request)
    {
        /**
         * @var AnnonceRepository $repository
         */
        $repository = $this->getDoctrine()->getRepository(Annonce::class);

        $params = [
            'betterThan' => $request->query->getInt('better-than'),
            'newerThan' => $request->query->get('newer-than')
        ];

        $annonces = $repository->findBySearch($params);
        
        if (!$annonces) {
            throw $this->createNotFoundException();
        }

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces
        ]);
    }

    /**
     * @Route("/annonce/{slug<^[a-z0-9]+(?:-[a-z0-9]+)*$>}", methods={"GET"})
     */
    public function annonceBySlug(Annonce $annonce)
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce
        ]);
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

    /**
     * @Route("/annonce/edit/{id<\d+>}")
     */
    public function edit(Annonce $annonce, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $em->flush();
        }

        return $this->render('annonce/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
