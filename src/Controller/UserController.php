<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * This controller allow us to edit user profile
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods: ['GET', 'POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('category.index');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            
            if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success', 'Vos informations ont bien été mis à jour'
                );
                return $this->redirectToRoute('category.index');
            }
            else {
                $this->addFlash(
                    'warning', 
                    'Le mot de passe est incorrect'
                );
                return $this->redirectToRoute('user.edit', ['id' => $user->getId()]);
            }

        }
        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/utilisateur/edition-mot-de-passe/{id}', name: 'user.edit.password', methods: ['GET', 'POST'])]
    public function editPassword(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            if ($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) {

                $user->setPlainPassword(
                    $form->getData()['newPassword']
                );
                $hashedPassword = $hasher->hashPassword($user, $user->getPlainPassword());
                $user->setPassword($hashedPassword);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success', 
                    'Votre mot de passe a bien été mis à jour'
                );
                return $this->redirectToRoute('category.index');
            }
            else {
                $this->addFlash(
                    'warning', 
                    'Le mot de passe est incorrect'
                );
                return $this->redirectToRoute('user.edit.password', ['id' => $user->getId()]);
            }
        }
        if($form->isSubmitted() && !$form->isValid()){
            $this->addFlash(
                'warning', 
                'Les mots de passe ne sont pas identiques'
            );
            return $this->redirectToRoute('user.edit.password', ['id' => $user->getId()]);
        }
        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView()
        ])
        
        ;
    }
}
