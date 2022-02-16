<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AddressRepository;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/api/annonce/search-by-position")
     */
    public function searchByPosition(
        Request $request,
        AddressRepository $addressRepository
        ): Response
    {
        $lat = $request->query->get('lat', 7.751077715342896 );
        $lng = $request->query->get('lon', 48.582518684576954);

        $radius = $request->query->get('radius', 12);

        $addresses = $addressRepository->findByPosition($lat, $lng, $radius);

        return $this->json($addresses, 200, [], [
            'groups' => ['address', 'annonce']
        ]);
    }
}
