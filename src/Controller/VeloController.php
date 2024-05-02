<?php

namespace App\Controller;

use App\Entity\Velo;
use App\Form\VeloType;
use App\Repository\VeloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VeloController extends AbstractController
{
    /**
     * This function display all velos
     *
     * @param VeloRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/velo', name: 'velo', methods: ['GET'])]
    public function index(VeloRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $velos = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), 
            10 /*limit per page*/
        );
        return $this->render('pages/velo/index.html.twig', [
            'velos' => $velos
        ]);
    }
    #[Route('/velo/new', name: 'velo.new', methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $manager): Response {
        $velo = new Velo();
        $form = $this->createForm(VeloType::class, $velo);
        $form ->handleRequest($request);
        if ($form ->isSubmitted() && $form ->isValid()) {
            $velo = $form->getData();
            $manager->persist($velo);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Votre vélo a bien été créé avec succès !'
            );
            return $this->redirectToRoute('velo');
        }
        
        return $this->render('pages/velo/new.html.twig', ['form' => $form->createView()]);
    
}
}