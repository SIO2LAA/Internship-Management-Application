<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;


class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        //Récuperer le denier message d'erreur
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error != null) {
            $error = 'Informations Incorrectes !';
        }
        
        //Récupérer le dernier nom utilisateur renseigné
        $lastUsername = $authenticationUtils->getLastUsername();
        
       
        return $this->render('connexion/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    
    
    /**
     * @Route("/deconnexion", name="app_logout")
     */
    public function logout(): void
    {
        
    }
    
    
    
    
    /**
     * @Route("/erreur", name="erreur")
     */
    
    public function erreur(): Response
    {
        // Redirige vers la page signalant un Access Denied
        return $this->render('erreur/erreur.html.twig', [
           
        ]);
    }
}
