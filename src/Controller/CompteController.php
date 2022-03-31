<?php

namespace App\Controller;

use App\Form\ModifierCompteEtudiantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ville;
use App\Entity\UserLogin;
use App\Entity\Utilisateur;
use App\Form\ModifierEtudiantType;
use App\Form\ModifierProfesseurType;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte")
     */
    
    public function index(): Response
    {
        $doc = $this->getDoctrine();
        $man = $doc->getManager();
        $repo = $man->getRepository(Utilisateur::class);

        $user = $this->getUser();
  
        $utilisateur = $repo->find($this->getUser()->getId());
        $nom = $utilisateur->getNom();
        $prenom = $utilisateur->getPrenom();
        $mail = $utilisateur->getMail();
        
        if (get_class($utilisateur) == 'App\Entity\Etudiant') {
            $adresse = $utilisateur->getAdresse();
            $complementAdresse = $utilisateur->getComplementAdresse();
            $telephone = $utilisateur->getTelephone();
            $dateNaissance = $utilisateur->getDateNaissance()->format('Y-m-d');
            if ($utilisateur->getVille() != null) {
                $ville = $utilisateur->getVille();
            } else {
                $ville = null;
            }
            
            $ret = $this->render('compte/index.html.twig', [
                'nom' => $nom,
                'prenom' => $prenom,
                'mail' => $mail,
                'adresse' => $adresse,
                'complementAdresse' => $complementAdresse,
                'telephone' => $telephone,
                'dateNaissance' => $dateNaissance,
                'ville' => $ville,
                'user' => $user,
                'type' => 'etudiant',
                'id' => $this->getUser()->getId(),
            ]);
            
        }elseif (get_class($utilisateur) == 'App\Entity\Professeur') {
            $ret = $this->render('compte/index.html.twig', [
                'nom' => $nom,
                'prenom' => $prenom,
                'mail' => $mail,
                'type' => 'professeur',
                'user' => $user,
            ]);
        }
        
        return $ret;
    }
    
    
    
    /**
     * @Route("/compte/modifier", name="modifier_compte")
     */
    
    public function modifierCompte(Request $req): Response
    {
        $doctrine = $this->getDoctrine();
        $man = $doctrine->getManager();
        $repo = $man->getRepository('App\Entity\Utilisateur');
        $utilisateur = $repo->find($this->getUser()->getId());

        $user = $this->getUser();

        if (get_class($utilisateur) == 'App\Entity\Etudiant') {
            $repoV = $man->getRepository('App\Entity\Ville');
            $dep_liste = $repoV->findAllDepartments();
            $listeVille = new Ville();
            $bln = false;
            if ($req->get('departement') != null) {
                $listeVille = $repoV->findBy(['numDepartement' => $req->get('departement')]);
                $bln = true;
            }
            $form = $this->createForm(ModifierCompteEtudiantType::class, $utilisateur, ['liste_ville' => $listeVille]);
            $form->handleRequest($req);
            
            if ($form->isSubmitted()) {
                
                $man->persist($utilisateur);
                $man->flush();
                
                $ret = $this->redirectToRoute('compte');
            } else {
                $ret = $this->render('compte/modifierCompte.html.twig', [
                    'formulaire' => $form->createView(),
                    'id' => $user->getId(),
                    'type' => 'etudiant',
                    'user' => $user,
                    'ville' => $bln,
                    'liste_dep' => $dep_liste,
                ]);
            }
            
        } elseif (get_class($utilisateur) == 'App\Entity\Professeur') {
            $form = $this->createForm(ModifierProfesseurType::class, $utilisateur);
            $form->handleRequest($req);

            if ($form->isSubmitted()) {
                
                $man->persist($utilisateur);
                $man->flush();
                
                $ret = $this->redirectToRoute('compte');
            } else {
                $ret = $this->render('compte/modifierCompte.html.twig', ['formulaire' => $form->createView(), 'id' => $user->getId(), 'type' => 'professeur', 'user' => $user]);
            }
        }
        return $ret;
    }
}
