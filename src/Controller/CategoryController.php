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
        /**
     * This controller display all category
     *
     * @param CategorieRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    #[Route('/categorie', name: 'category.index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, Request $request, CategorieRepository $repository): Response
    {
        $categories = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), 
            5 /*limit per page*/
        );
        return $this->render('pages/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    /**
     * This controller allows to create a new category
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/categorie/new', name: 'category.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response {
        $categorie = new Categorie();
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $manager->persist($categorie);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre catégorie a bien été créé avec succès !'
            );
        return $this->redirectToRoute('category.index');
        }
return $this->render('pages/category/new.html.twig', ['form' => $form]);
    }
    /**
     * This controller allows to delete a category
     * @param  Categorie $velo
     * @param EntityManagerInterface $manager
     * @return Response
     * @param VeloRepository $veloRepository
     */
    #[Route('/categorie/suppression/{id}', name: 'category.delete', methods: ['GET'])]
public function delete( Categorie $categorie,VeloRepository $veloRepository,EntityManagerInterface $manager): Response {
    $velo = $veloRepository->findBy(['categorie' => $categorie->getId()]);
    foreach ($velo as $value) {
        $value->setCategorie(null);
    }
    
    $manager->remove($categorie);
    $manager->flush();
    $this->addFlash(
        'success',
        'Votre catégorie a bien été supprimé avec succès !'
    );
    
    return $this->redirectToRoute('category.index');}
    /**
     * This controller allows to edit a category
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param  Categorie $categorie
     */
    #[Route('/categorie/edition/{id}', name: 'category.edit', methods: ['GET', 'POST'])]
public function edit(Request $request, EntityManagerInterface $manager, Categorie $categorie) : Response {
        
        $form = $this->createForm(CategoryType::class, $categorie,[
            'categorie_id' => $categorie->getId()
        ]);
        $form ->handleRequest($request);
        if ($form ->isSubmitted() && $form ->isValid()) {
            $categorie = $form->getData();
            $velo = $request->request->get('velos');
            foreach($categorie->getVelos() as $velo){
                $velo->setCategorie($categorie);
                
            }
            $manager->persist($categorie);
            $manager->persist($velo);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Votre catégorie a bien été modifié avec succès !'
            );
            return $this->redirectToRoute('category.index');
        }
    return $this->render('pages/category/edit.html.twig', ['form' => $form->createView()]);
}
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
