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
     * This controller display all velos
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



    /**
     * This controller show the form to create a new velo
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
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

#[Route('/velo/suppression/{id}', name: 'velo.delete', methods: ['GET'])]
public function delete( Velo $velo, EntityManagerInterface $manager): Response {
    
    $manager->remove($velo);
    $manager->flush();
    $this->addFlash(
        'success',
        'Votre vélo a bien été supprimé avec succès !'
    );
    return $this->redirectToRoute('velo');}

#[Route('/velo/edition/{id}', name: 'velo.edit', methods: ['GET', 'POST'])]
public function edit(Request $request, EntityManagerInterface $manager, Velo $velo) : Response {
        $form = $this->createForm(VeloType::class, $velo);
        $form = $this->createForm(VeloType::class, $velo);
        $form ->handleRequest($request);
        if ($form ->isSubmitted() && $form ->isValid()) {
            $velo = $form->getData();
            $manager->persist($velo);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Votre vélo a bien été modifié avec succès !'
            );
            return $this->redirectToRoute('velo');
        }
    return $this->render('pages/velo/edit.html.twig', ['form' => $form->createView()]);}
}


