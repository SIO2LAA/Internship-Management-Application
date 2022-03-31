<?php

namespace App\Controller;
use App\Entity\Entreprise;
use App\Entity\Professionnel;
use App\Form\ProfessionnelType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfessionnelController extends AbstractController
{

    /**
     * @Route("/entreprise/professionnel", name="professionnel_liste")
     */
    public function listeProfessionnel(): Response
    {
        $doc = $this->getDoctrine();
        $man = $doc->getManager();
        $repoPers = $man->getRepository('\App\Entity\Professionnel');
        $list= $repoPers->findAll();

        $user = $this->getUser();


        $response=$this->render('professionnel/listeProfessionnel.html.twig', [
            'liste_professionnel'=>$list,
            'user' => $user
        ]);
        return $response;
    }
    
    /**
     * @Route("/entreprise/professionnel/afficher/{id}", name="professionnel_afficher")
     */
    public function afficher(Request $req, $id): Response {
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repoP = $man->getRepository('App\Entity\Professionnel');
        $professionnel = $repoP->find($id);
        
        $user = $this->getUser();
        
        $res = $this->render('professionnel/afficher.html.twig', [
            'professionnel' => $professionnel,
            'user' => $user,
        ]);
        return $res;
    }

    /**
     * @Route("/entreprise/professionnel/ajouter", name="professionnel_ajouter")
     */
    public function add(Request $req): Response {
        $professionnel = new Professionnel();
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repoE = $man->getRepository('App\Entity\Entreprise');
        $ent_liste = $repoE->findAll();

        $user = $this->getUser();

        $form = $this->createForm(ProfessionnelType::class, $professionnel, ['ent_liste' => $ent_liste]);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $man->persist($professionnel);
            $man->flush();
            $res = $this->redirectToRoute('professionnel_liste');
        }else {
            $res = $this->render('professionnel/ajouter.html.twig', [
                'formulaire' => $form->createView(),
                'user' => $user,
            ]);
        }
        return $res;
    }



    /**
     * @Route("/professionnel/modifier/{id}", name="professionnel_modifier")
     */
    public function modifierPro(Request $req,int $id):Response{
        $doc = $this->getDoctrine();
        $man = $doc ->getManager();
        $repos = $man->getRepository('App\Entity\Professionnel');
        $modifPro = $repos->find($id);
        $repoE = $man->getRepository('App\Entity\Entreprise');
        $ent_liste = $repoE->findAll();


        $user = $this->getUser();

        $form = $this -> createForm(ProfessionnelType::class, $modifPro,['ent_liste' =>  $ent_liste]);
        $form->handleRequest($req);

        if($form->isSubmitted()){
            $man->persist($modifPro);
            $man->flush();
            $res = $this->redirectToRoute('professionnel_liste');
        }
        else{
            $res = $this->render('professionnel/ajouter.html.twig',[
                'formulaire' => $form->createView(),
                'user' => $user,
            ]);
        }

        return $res;
    }
    
    /**
     * @Route("/entreprise/professionnel/supprimer/{id}", name="professionnel_supprimer")
     */
    public function supprimerPro(Request $req,int $id):Response{
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repos = $man->getRepository('App\Entity\Professionnel');
        $suprimmerPro = $repos->find($id);
        
        
        
        $man->remove($suprimmerPro);
        $man->flush();
        
        return $this->redirectToRoute('professionnel_liste');
        
    }

}
