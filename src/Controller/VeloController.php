<?php

namespace App\Controller;

use App\Entity\Velo;
use App\Repository\VeloRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\NotesRepository;

class VeloController extends AbstractController
{


    #[Route('/velo/show/{id}', name: 'velo.show', methods: ['GET'])]
public function showVelo(Velo $velo, VeloRepository $repository , NotesRepository $notesRepository): Response
{
    // Récupère les informations complètes du vélo en utilisant son ID
    $velo = $repository->find($velo->getId());

    // Récupère les détails spécifiques du vélo (taille, roues, etc.)
    // $details = $velo->getDetails();
    // $taille = $details->getTaille(); // Taille du vélo
    // $roues = $details->getRoues();   // Taille des roues

    // Récupère la note moyenne attribuée à ce vélo
    $averageRating = $notesRepository->findAverageRating($velo->getId());

    // Retourne la vue 'show.html.twig' avec les données du vélo
    return $this->render('pages/velo/show.html.twig', [
        'velo' => $velo,               // Les informations du vélo
        'notes' => $averageRating[1],  // La note moyenne attribuée à ce vélo
        // 'details' => $details,         // Les détails du vélo
        // 'taille' => $taille,           // Taille du vélo
        // 'roues' => $roues              // Roues du vélo
    ]);
}
    #[Route('/velo/showall', name: 'velo.showall', methods: ['GET'])]
public function showAllVelo(VeloRepository $repository, Request $request): Response
{
    // Récupère le mot-clé de recherche à partir des paramètres de la requête (s'il y en a un)
    $keyword = $request->query->get('q');

    // Récupère la liste de tous les vélos ordonnés selon une méthode spécifique du repository
    $velos = $repository->findAllOrder();

    // Si un mot-clé de recherche est présent, utilise une méthode de recherche pour filtrer les vélos
    if ($keyword !== null) {
        $velos = $repository->searchVelo($keyword);
    }

    // Retourne la vue 'showall.html.twig' avec la liste des vélos filtrée (ou complète si pas de mot-clé)
    return $this->render('pages/velo/showall.html.twig', [
        'velos' => $velos // Liste des vélos à afficher
    ]);
}
}
