<?php

namespace App\Controller;


use App\Entity\Ville;
use App\Entity\Profil;
use App\Form\EntrepriseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Entity\Professionnel;
use App\Form\ProfessionnelType;
use App\Form\ModifierEntrepriseType;


class EntrepriseController extends AbstractController {

    /**
     * @Route("/entreprise", name="entreprise_liste")
     */
    public function listeEntreprise(Request $req): Response
    {
            $doc = $this->getDoctrine();
            $man = $doc->getManager();
            $repoEnt = $man->getRepository('\App\Entity\Entreprise');
            $repoVille = $man->getRepository('\App\Entity\Ville');
            $dep_liste = $repoVille->findAllDepartments();
            $user = $this->getUser();
            if ($req->get('departement') != null) {
                $departement = $req->get('departement');
                $ville_liste = $repoVille->findBy(['numDepartement' => $departement]);
                foreach ($ville_liste as $ville) {
                    foreach ($ville->getEntreprises() as $ent) {
                        $ent_liste[] = $ent;
                    }
                }
                if (empty($ent_liste)) {
                    $ent_liste = null;
                }
            } elseif ($req->get('specialite') != null) {
                $ent_liste = $repoEnt->findBy(['specialite' => $req->get('specialite')]);
            } else {
                $ent_liste= $repoEnt->findAll();
            }
            
            $response=$this->render('entreprise/listeEntreprise.html.twig', ['liste_ent'=>$ent_liste, 'liste_dep' => $dep_liste, 'user' => $user]);
            return $response;
    }
    
    /**
     * @Route("/entreprise/ajouter", name="entreprise_ajouter")
     */
  
    public function ajouter(Request $req): Response
    {
        //récupérer la liste des villes
        $entreprise = new Entreprise();
        $doc = $this->getDoctrine();
        $man = $doc ->getManager();
        $repoV = $man->getRepository('App\Entity\Ville');
        $dep_liste = $repoV->findAllDepartments();

        $user = $this->getUser();

        $ville_liste = new Ville();
        $bln = false;
        if ($req->get('departement') != null) {
          $ville_liste = $repoV->findBy(['numDepartement' => $req->get('departement')]);
          $bln = true;
        }
        $repoP = $man->getRepository('App\Entity\Profil');
        $specialite_liste = $repoP->findAll();
        $form = $this -> createForm(EntrepriseType::class, $entreprise, ['listeVille' => $ville_liste,'specialiteListe' => $specialite_liste]);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $man->persist($entreprise);
            $man->flush();
            $res = $this->redirectToRoute('entreprise_liste');
        } else{
            $res = $this->render('entreprise/ajouter.html.twig',[
                'formulaire' => $form->createView(),
                'user' => $user,
                'title'=> 'Ajouter',
                'ville' => $bln,
                'liste_dep' => $dep_liste,
            ]);
        }
        return $res;
    }
    
    /**
     * @Route("/entreprise/afficher/{id}", name="entreprise_afficher")
     */
    public function afficher(Request $req, $id): Response {
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repoE = $man->getRepository('App\Entity\Entreprise');
        $entreprise = $repoE->find($id);
        
        $user = $this->getUser();
        
        $res = $this->render('entreprise/afficher.html.twig', [
            'entreprise' => $entreprise,
            'user' => $user,
        ]);
        return $res;
    }

    /**
     * @Route("/entreprise/modifier/{id}", name="entreprise_modifier")
     */
    public function modifier(Request $req,int $id):Response{
        $doc = $this->getDoctrine();
        $man = $doc ->getManager();
        $repoProfil = $man->getRepository('App\Entity\Profil');
        $specialite_liste = $repoProfil->findAll();
        $repoE = $man->getRepository('App\Entity\Entreprise');
        $entreprise = $repoE->find($id);

        $user = $this->getUser();

        $repoV = $man->getRepository('App\Entity\Ville');
        $dep_liste = $repoV->findAllDepartments();
        $ville_liste = new Ville();
        $bln = false;
        if ($req->get('departement') != null) {
          $ville_liste = $repoV->findBy(['numDepartement' => $req->get('departement')]);
          $bln = true;
        }
        $repoP = $man->getRepository('App\Entity\Profil');
        $specialite_liste = $repoP->findAll();
        $form = $this -> createForm(EntrepriseType::class, $entreprise, ['listeVille' => $ville_liste,'specialiteListe' => $specialite_liste]);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $man->persist($entreprise);
            $man->flush();
            $res = $this->redirectToRoute('entreprise_liste');
        } else{
            $res = $this->render('entreprise/ajouter.html.twig',[
                'formulaire' => $form->createView(),
                'id_ent' => $id,
                'user' => $user,
                'title'=> 'Modifier',
                'ville' => $bln,
                'liste_dep' => $dep_liste,
            ]);
        }

        return $res;
    }


    /**
     * @Route("/entreprise/supprimer/{id}", name="entreprise_supprimer")
     */
    public function supprimer(Request $req,int $id):Response{
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repoEntreprise = $man->getRepository('App\Entity\Entreprise');
        $entreprise = $repoEntreprise->find($id);
        $man->remove($entreprise);
        $man->flush();
        return $this->redirectToRoute('entreprise_liste');
    }
    








}
