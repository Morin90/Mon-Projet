<?php

namespace App\Controller;

use App\Entity\Velo;
use App\Repository\VeloRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\DetailsRepository;
use App\Repository\NotesRepository;

class VeloController extends AbstractController
{


    #[Route('/velo/show/{id}', name: 'velo.show', methods: ['GET'])]
    public function showVelo(Velo $velo, VeloRepository $repository , NotesRepository $notesRepository, DetailsRepository $detailsRepository): Response
    {

        $velo = $repository->find($velo->getId());
        $details = $velo->getDetails();
        $taille = $details->getTaille();
        $roues = $details->getRoues();
        $averageRating = $notesRepository->findAverageRating($velo->getId());
        return $this->render('pages/velo/show.html.twig', [
            'velo' => $velo , 'notes' => $averageRating[1], 'details' => $details, 'taille' => $taille, 'roues' => $roues
        ]);
    }
    #[Route('/velo/showall', name: 'velo.showall', methods: ['GET'])]
    public function showAllVelo(VeloRepository $repository, Request $request ): Response
    {
        $keyword = $request->query->get('q');
        $velos = $repository->findAllOrder();
        if ($keyword !== null) {
            $velos = $repository->searchVelo($keyword);
        }
        return $this->render('pages/velo/showall.html.twig', [
            'velos' => $velos
        ]);
    }
}
