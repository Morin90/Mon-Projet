<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Entity\Frame;
use App\Entity\Wheel;
use App\Form\BrandType;
use App\Form\FrameType;
use App\Form\WheelType;
use App\Entity\Transmission;
use App\Form\TransmissionType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/infos', name: 'admin_infos_')]
class AdminInfosController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('pages/admin/admin_infos.html.twig');
    }
    #[Route('/manage/frame', name: 'manage_frame')]
    public function manageFrame(Request $request,  PaginatorInterface $paginator): Response
    {
        // Récupération de toutes les entités pour le type donné
        $items = $paginator->paginate(
            $this->entityManager->getRepository(Frame::class)->findByOrderAsc(),
            $request->query->getInt('page', 1),
            10 /*limit per page*/
        );
        
        // Création du formulaire pour ajouter un nouvel élément
        $form = $this->createForm(FrameType::class, new Frame());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $this->entityManager->persist($item);
            $this->entityManager->flush();

            $this->addFlash('success', 'Cadre ajouté(e) avec succès.');
            return $this->redirectToRoute('admin_infos_manage_frame');
        }

        return $this->render('pages/admin/manage_frame.html.twig', [
            'form' => $form->createView(),
            'items' => $items
        ]);
    }

    #[Route('/delete/frame/{id}', name: 'delete_frame')]
    public function deleteFrame( int $id): Response
    {

        $item = $this->entityManager->getRepository(Frame::class)->find($id);
        if ($item) {
            $this->entityManager->remove($item);
            $this->entityManager->flush();
            $this->addFlash('success ', 'Cadre supprimé(e) avec succès.');
        } else {
            $this->addFlash('error',"Cadre n'existe pas.");
        }

        return $this->redirectToRoute('admin_infos_manage_frame');
    }

    #[Route('/manage/brand', name: 'manage_brand')]
    public function manageBrand(Request $request,  PaginatorInterface $paginator): Response
    {
        // Récupération de toutes les entités pour le type donné
        $items = $paginator->paginate(
            $this->entityManager->getRepository(Brand::class)->findByOrderAsc(),
            $request->query->getInt('page', 1),
            10 /*limit per page*/
        );
        // Création du formulaire pour ajouter un nouvel élément
        $form = $this->createForm(BrandType::class, new Brand());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $this->entityManager->persist($item);
            $this->entityManager->flush();

            $this->addFlash('success', 'Marque ajouté(e) avec succès.');
            return $this->redirectToRoute('admin_infos_manage_brand');
        }

        return $this->render('pages/admin/manage_brand.html.twig', [
            'form' => $form->createView(),
            'items' => $items,
        ]);
    }

    #[Route('/delete/brand/{id}', name: 'delete_brand')]
    public function deleteBrand( int $id): Response
    {

        $item = $this->entityManager->getRepository(Brand::class)->find($id);
        if ($item) {
            $this->entityManager->remove($item);
            $this->entityManager->flush();
            $this->addFlash('success ', 'Marque supprimé(e) avec succès.');
        } else {
            $this->addFlash('error',"Marque n'existe pas.");
        }

        return $this->redirectToRoute('admin_infos_manage_brand');
    }

    #[Route('/manage/wheel', name: 'manage_wheel')]
    public function manageWheel(Request $request,  PaginatorInterface $paginator): Response
    {
        // Récupération de toutes les entités pour le type donné
        $items = $paginator->paginate(
            $this->entityManager->getRepository(Wheel::class)->findByOrderAsc(),
            $request->query->getInt('page', 1),
            10 /*limit per page*/
        );
        
        // Création du formulaire pour ajouter un nouvel élément
        $form = $this->createForm(WheelType::class, new Wheel());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $this->entityManager->persist($item);
            $this->entityManager->flush();

            $this->addFlash('success', 'Taille de roues ajouté(e) avec succès.');
            return $this->redirectToRoute('admin_infos_manage_wheel');
        }

        return $this->render('pages/admin/manage_wheel.html.twig', [
            'form' => $form->createView(),
            'items' => $items,
        ]);
    }

    #[Route('/delete/wheel/{id}', name: 'delete_wheel')]
    public function deleteWheel( int $id): Response
    {

        $item = $this->entityManager->getRepository(Wheel::class)->find($id);
        if ($item) {
            $this->entityManager->remove($item);
            $this->entityManager->flush();
            $this->addFlash('success ', 'Taille de roues supprimé(e) avec succès.');
        } else {
            $this->addFlash('error',"Cette taille de roues n'existe pas.");
        }

        return $this->redirectToRoute('admin_infos_manage_wheel');
    }

    #[Route('/manage/transmission', name: 'manage_transmission')]
    public function manageTransmission(Request $request,  PaginatorInterface $paginator): Response
    {
        // Récupération de toutes les entités pour le type donné
        $items = $paginator->paginate(
            $this->entityManager->getRepository(Transmission::class)->findByOrderAsc(),
            $request->query->getInt('page', 1),
            10 /*limit per page*/
        );
        
        // Création du formulaire pour ajouter un nouvel élément
        $form = $this->createForm(TransmissionType::class, new Transmission());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $this->entityManager->persist($item);
            $this->entityManager->flush();

            $this->addFlash('success', 'Nombre de vitesses ajouté(e) avec succès.');
            return $this->redirectToRoute('admin_infos_manage_transmission');
        }

        return $this->render('pages/admin/manage_transmission.html.twig', [
            'form' => $form->createView(),
            'items' => $items,
        ]);
    }

    #[Route('/delete/transmission/{id}', name: 'delete_transmission')]
    public function deleteTransmission( int $id): Response
    {

        $item = $this->entityManager->getRepository(Transmission::class)->find($id);
        if ($item) {
            $this->entityManager->remove($item);
            $this->entityManager->flush();
            $this->addFlash('success ', 'Nombre de vitesses supprimé(e) avec succès.');
        } else {
            $this->addFlash('error',"Ce nombre de vittesses n'existe pas.");
        }

        return $this->redirectToRoute('admin_infos_manage_transmission');
    }
}
