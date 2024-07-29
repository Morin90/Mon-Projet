<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Repository\NotesRepository;
use App\Repository\UserRepository;
use App\Repository\VeloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;

class NoteController extends AbstractController
{
    #[Route('/note', name: 'app.note', methods: ['GET'])]
    public function note(
        Request $request,
        EntityManagerInterface $manager,
        VeloRepository $veloRepository,
        UserRepository $userRepository,
        NotesRepository $notesRepository
    ): Response {
        $note = new Notes();
        $velo = $veloRepository->find((int)$request->query->get('veloId'));
        $user = $userRepository->find((int)$request->query->get('userId'));
        if ($request->query->has('veloId') && $request->query->has('userId') && $request->query->has('note')) {
            $notes = $notesRepository->findBy(['velo' => $velo->getId(), 'user' => $user->getId()]);
            if (count($notes) === 0) {
                $note->setVelo($velo);
                $note->setUser($user);
                $note->setRating((int)$request->query->get('note')+1);
                $manager->persist($note);
                $manager->flush();
                return $this->json(['message' => 'added'], 201);
            }
        }
        return $this->json(['message' => 'Vous avez deja noté ce velo'], 400);
    }
}
