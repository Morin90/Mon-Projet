<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * This controller allow user to login
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/connexion', name: 'security.login', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
    
        return $this->render('pages/security/login.html.twig', [
            'lastUsername' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
    /**
     * This controller allow user to logout
     *
     * @return void
     */
    #[Route('/deconnexion', name: 'security.logout')]
    public function logout(){
        // return $this->render('pages/security/login.html.twig');
    }
    /**
     * This controller allow to register a new user
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/inscription', name: 'security.registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager) : Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData();
            $this->addFlash('success', 'Votre compte a bien été créé !');
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('security.login');
        }
        return $this->render('pages/security/registration.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
