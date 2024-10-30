<?php

namespace App\Controller\Admin;

use App\Entity\Velo;
use App\Form\VeloType;
use App\Repository\VeloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminVeloController extends AbstractController
{
    

    /**
     * This controller display all velos
     *
     * @param VeloRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/admin_velo', name: 'velo', methods: ['GET'])]
    public function index(VeloRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $velos = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10 /*limit per page*/
        );
        return $this->render('pages/admin/admin_velo/index.html.twig', [
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
    #[Route('/admin_velo/new', name: 'velo.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $velo = new Velo();
        $form = $this->createForm(VeloType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($velo, $request->request->all());
            $manager->persist($velo);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre vélo a bien été créé avec succès !'
            );
            return $this->redirectToRoute('velo');
        }

        return $this->render('pages/admin/admin_velo/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/admin_velo/suppression/{id}', name: 'velo.delete', methods: ['GET'])]
    public function delete(Velo $velo, EntityManagerInterface $manager): Response
    {

        $manager->remove($velo);
        $manager->flush();
        $this->addFlash(
            'success',
            'Votre vélo a bien été supprimé avec succès !'
        );
        return $this->redirectToRoute('velo');
    }

    #[Route('/admin_velo/edition/{id}', name: 'velo.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $manager, Velo $velo): Response
    { //Création du formulaire
        $form = $this->createForm(VeloType::class, $velo);
        //Préremplir les champs du formulaire avec les détails du velo
        // $form->get('taille')->setData($velo->getDetails()->getTaille());
        // $form->get('roues')->setData($velo->getDetails()->getRoues());
        // $form->get('vitesses')->setData($velo->getDetails()->getVitesse());
        // gérer la requête pour voir si le formulaire a été soumis
        $form->handleRequest($request);
        // condition : si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // on persiste le velo dans la base de donnée
            $velo->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($velo);
            // sauvegarder les modifications
            $manager->flush();

            // message flach pour avertir l'utilisateur que le velo a été modifié
            $this->addFlash(
                'success',
                'Votre vélo a bien été modifié avec succès !'
            );
            // redirection vers la page des velos
            return $this->redirectToRoute('velo');
        }
        //  Si le formulaire n'est pas soumis ou n'est pas valide, afficher la page de modification avec le formulaire
        return $this->render('pages/admin/admin_velo/edit.html.twig', ['form' => $form->createView()]);
    }
}
