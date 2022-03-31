<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Entity\Profil;
use App\Entity\Promotion;
use App\Entity\UserLogin;
use App\Entity\Utilisateur;
use App\Entity\Ville;
use App\Form\AjoutEtudiantType;
use App\Form\AjoutProfesseurType;
use App\Form\AjoutUtilisateurType;
use App\Form\ModifierPasswordUtilisateurType;
use App\Form\ModifierEtudiantType;
use App\Form\ModifierProfesseurType;
use Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Routing\Annotation\Route;
use PHPUnit\Framework\Constraint\IsEmpty;


class UtilisateurController extends AbstractController {
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function liste(Request $req): Response
    {
        $doc = $this->getDoctrine();
        $man = $doc->getManager();
        $repoList = $man->getRepository('\App\Entity\Utilisateur');
        $listeEtu = [];
        $listeProf = [];

        $user = $this->getUser();

        foreach ($repoList->findAll() as $value) {
            if (get_class($value) == 'App\Entity\Etudiant') {
                $listeEtu[] = $value;
            }
            else {
                $listeProf[] = $value;
            }
        }

        return $this->render('utilisateur/listeUtilisateur.html.twig', [
            'listeEtu' => $listeEtu,
            'listeProf' => $listeProf,
            'user' => $user
        ]);
    }
    
    public function getAttributes(String $className) {
        $doc = $this->getDoctrine();
        $man = $doc->getManager();
        $reflectionExtractor = new ReflectionExtractor();
        $doctrineExtractor = new DoctrineExtractor($man);
        $propertyInfo = new PropertyInfoExtractor(
            // List extractors
            [
                $reflectionExtractor,
                $doctrineExtractor
            ],
            // Type extractors
            [
                $doctrineExtractor,
                $reflectionExtractor
            ]
            );
        return $propertyInfo->getProperties($className);
    }
            
    /**
     * @Route("/utilisateur/modifier/{id}", name="utilisateur_modifier")
     */
    public function modifierUtilisateur(Request $req, int $id): Response
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();
        $repoL = $manager->getRepository('App\Entity\Utilisateur');
        $repoV = $manager->getRepository('App\Entity\Ville');
        $repoP = $manager->getRepository('App\Entity\Promotion');
        $repoS = $manager->getRepository('App\Entity\Profil');
        $utilisateur = $repoL->find($id);

        $user = $this->getUser();

        if (get_class($utilisateur) == 'App\Entity\Etudiant') {
            $dep_liste = $repoV->findAllDepartments();
            $liste_ville = new Ville();
            $bln = false;
            if ($req->get('departement') != null) {
                $liste_ville = $repoV->findBy(['numDepartement' => $req->get('departement')]);
                $bln = true;
            }
            $liste_promotion = $repoP->findAll();
            $liste_specialite = $repoS->findAll();
            
            $form = $this->createForm(ModifierEtudiantType::class, $utilisateur, ['liste_ville' => $liste_ville, 'liste_promotion' => $liste_promotion, 'liste_specialite' => $liste_specialite]);
            $form->handleRequest($req);
            
            if ($form->isSubmitted()) {
                
                $manager->persist($utilisateur);
                $manager->flush();
                
                $ret = $this->redirectToRoute('utilisateur');
            } else {
                $ret = $this->render('utilisateur/modifierUtilisateur.html.twig', [
                    'formulaire' => $form->createView(),
                    'id' => $id,
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

                $manager->persist($utilisateur);
                $manager->flush();
                    
                $ret = $this->redirectToRoute('utilisateur');
            } else {
                $ret = $this->render('utilisateur/modifierUtilisateur.html.twig', [
                    'formulaire' => $form->createView(),
                    'id' => $id,
                    'type' => 'professeur',
                    'user' => $user,
                ]);
            }
        }
        return $ret;
    }

    /**
     * @Route("/compte/modifier/password/{id}", name="utilisateur_modifier_password")
     */
    public function modifierPasswordUtilisateur(Request $req, int $id, UserPasswordHasherInterface $hasher): Response
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();
        $repoL = $manager->getRepository('App\Entity\Utilisateur');
        $utilisateur = $repoL->find($id);

        $user = $this->getUser();
        
        $isProf = false;
        foreach ($user->getRoles() as $role) {
            if ($role == 'ROLE_PROFESSEUR') {
                $isProf = true;
            }
        }
        if (!$isProf) {
            if ($id != $user->getId() && !$isProf) {
                return $this->redirectToRoute('compte');
            }
        }
    
        $form = $this->createForm(ModifierPasswordUtilisateurType::class, $utilisateur);
        $form->handleRequest($req);

        if ($form->isSubmitted()) {

            if ($form->get('login')->get('password')->get('first')->getData() == $form->get('login')->get('password')->get('second')->getData()){

                $pass_hash = $hasher->hashPassword($utilisateur->getLogin(), $form->get('login')->get('password')->get('second')->getData());
                $utilisateur->getLogin()->setPassword($pass_hash);
                $manager->persist($utilisateur);
                $manager->flush();

            }// Mettre condition avec un message flash d'erreur(sur la meme page)

            $ret = $this->redirectToRoute('utilisateur');
        } else {
              $ret = $this->render('utilisateur/modifierPasswordUtilisateur.html.twig', ['formulaire' => $form->createView(), 'user' => $user]);
        }
        
        return $ret;
    }

    /**
     * @Route("/utilisateur/etudiant/ajout", name="etudiant_ajouter")
     */
    public function ajouterEtudiant(Request $req): Response
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();
        $repoP = $manager->getRepository('App\Entity\Promotion');
        $liste_promotion = $repoP->findAll();
        $form = $this->createForm(AjoutEtudiantType::class, null, ['liste_promotion' => $liste_promotion]);
        $form->handleRequest($req);

        $user = $this->getUser();


        if ($form->isSubmitted()) {//Mettre une gestion d'erreur pour l'upload du fichier et les colonnes existantes
            $file = $form->get('file');
            $encoders = [new CsvEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);

            foreach ($serializer->decode(file_get_contents($file->getData()), 'csv') as $r) {
                $data[] = $r;
            }

                foreach ($data as $rE) {
                    $userLoginE = (new UserLogin())
                        ->setIdentifiant($rE['identifiant'])
                        ->setRoles(["ROLE_ETUDIANT"])
                        ->setPassword(password_hash('apStages', PASSWORD_BCRYPT, $cost = [15]));

                    $etudiant = (new Etudiant())
                        ->setNom($rE['nom'])
                        ->setPrenom($rE['prenom'])
                        ->setMail($rE['mail'])
                        ->setType('etu')
                        ->setLogin($userLoginE);

                    $etudiant->setPromotion($form->get('promotion')->getData());

                    $manager->persist($etudiant);
                    $manager->flush();
                }

            $ret = $this->redirectToRoute('utilisateur');

        }
        else {
            $ret = $this->render('utilisateur/ajoutUtilisateur.html.twig', ['formulaire' => $form->createView(), 'type' => 'etu', 'user' => $user]);
        }

        return $ret;
    }

    /**
     * @Route("/utilisateur/professeur/ajout", name="professeur_ajouter")
     */
    public function ajouterProfesseur(Request $req): Response
    {
        $form = $this->createForm(AjoutProfesseurType::class);
        $form->handleRequest($req);

        $user = $this->getUser();

        if ($form->isSubmitted()) {//Mettre une gestion d'erreur pour l'upload du fichier et les colonnes existantes
            $file = $form->get('file');
            $doctrine = $this->getDoctrine();
            $manager = $doctrine->getManager();
            $encoders = [new CsvEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);

            foreach ($serializer->decode(file_get_contents($file->getData()), 'csv') as $r) {
                $data[] = $r;
            }
                foreach ($data as $rP) {
                    $userLoginP = (new UserLogin())
                        ->setIdentifiant($rP['identifiant'])
                        ->setRoles(["ROLE_PROFESSEUR"])
                        ->setPassword(password_hash('adminStages', PASSWORD_BCRYPT, $cost = [15]));

                    $professeur = (new Professeur())
                        ->setNom($rP['nom'])
                        ->setPrenom($rP['prenom'])
                        ->setMail($rP['mail'])
                        ->setType('prof')
                        ->setLogin($userLoginP);

                    $manager->persist($professeur);
                    $manager->flush();
                }

            $ret = $this->redirectToRoute('utilisateur');

        }
        else {
            $ret = $this->render('utilisateur/ajoutUtilisateur.html.twig', ['formulaire' => $form->createView(), 'type' => 'prof', 'user' => $user,
            ]);
        }

        return $ret;
    }

    /**
     * @Route("/utilisateur/supprimer/{id}", name="utilisateur_supprimer")
     */
    public function delete(Request $req, int $id): Response {
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repos = $man->getRepository('App\Entity\Utilisateur');
        $utilisateur = $repos->find($id);
        $man->remove($utilisateur);
        $man->flush();
        $ret = $this->redirectToRoute('utilisateur');
        return $ret;
    }

    /**
     * @Route("/utilisateur/afficher/{id}", name="utilisateur_afficher")
     */
    public function afficher(Request $req, $id): Response {
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repos = $man->getRepository('App\Entity\Utilisateur');
        $utilisateur = $repos->find($id);
        $user = $this->getUser();
        $type = '';
        if (get_class($utilisateur) == 'App\Entity\Etudiant') {
            $type = 'Etudiant';
        } elseif (get_class($utilisateur) == 'App\Entity\Professeur') {
            $type = 'Professeur';
        }
        $ret = $this->render('utilisateur/afficherUtilisateur.html.twig', [
            'utilisateur' => $utilisateur,
            'type' => $type,
            'user' => $user,
        ]);
        return $ret;
    }

}
