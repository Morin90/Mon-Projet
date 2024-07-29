<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Velo;
use App\Form\CategoryType;
use App\Repository\CategorieRepository;
use App\Repository\VeloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CategoryController extends AbstractController
{

    #[Route('/category/show', name: 'category.show', methods: ['GET'])]
    public function showCategory(CategorieRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render('pages/category/show.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/category/showone/{id}', name: 'category.showone', methods: ['GET'])]
    public function showOneCategory(CategorieRepository $repository, Categorie $categorie, VeloRepository $veloRepository): Response
    {
        $categorie = $repository->findOneBy(['id' => $categorie->getId()]);
        $velos = $veloRepository->findBy(['categorie' => $categorie->getId()]);
        return $this->render('pages/category/show_one.html.twig', [
            'categorie' => $categorie,
            'velos' => $velos
        ]);
    }
}
