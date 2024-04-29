<?php

namespace App\Controller;

use App\Repository\VeloRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VeloController extends AbstractController
{
    #[Route('/velo', name: 'app_velo')]
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
}
