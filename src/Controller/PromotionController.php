<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\AjoutPromotionType;
use App\Form\PromotionType;
use App\Form\ReturnType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//Commentaire

class PromotionController extends AbstractController
{
     /**
     * @Route("/promotion", name="promotion")
     */
    public function promotion(Request $req): Response
    {
        $doc = $this->getDoctrine();
        $man = $doc->getManager();
        $repos = $man->getRepository('App\Entity\Promotion');
        $promo_liste = $repos->findAll();

        $user = $this->getUser();

        $form = $this->createForm(PromotionType::class,null, [
            'promo_liste' => $promo_liste,
        ]);
        $form->handleRequest($req);
        
        if ($form->isSubmitted()) {
            if ($form->get('bouton_ajout')->isClicked()){
                $res = $this->redirectToRoute('promotion_ajouter', array('error' => ' '));
            }
            if ($form->get('bouton_modif')->isClicked()){
                $res = $this->redirectToRoute('promotion_modifier',  array('id' => $form->get('promo_liste')->getData()->getId(), 'error' => ' '));
            }
            if ($form->get('bouton_supp')->isClicked()){
                $man->remove($form->get('promo_liste')->getData());
                $man->flush();
                $res = $this->redirectToRoute('promotion');
            }
            if ($form->get('bouton_return')->isClicked()){
                $res = $this->redirectToRoute('accueil');
            }
        }
        else {
            $res = $this->render('promotion/promotion.html.twig', [
                'formulaire' => $form->createView(),
                'user' => $user
            ]);
        }
        return $res;
    }
    
    /**
     * @Route("/promotion/ajouter/{error}", name="promotion_ajouter")
     */
    public function add(Request $req, $error): Response {
        
        $promo = new Promotion();
        $doc = $this->getDoctrine();
        $man = $doc->getManager();
        
        $form = $this->createForm(AjoutPromotionType::class,$promo);
        $form->handleRequest($req);
        
        $formReturn = $this->createForm(ReturnType::class);
        $formReturn->handleRequest($req);

        $user = $this->getUser();

        if ($form->isSubmitted()) {
            if ($promo->getAnneeDebut() < $promo->getAnneeFin()) {
                $man->persist($promo);
                $man->flush();
                $res = $this->redirectToRoute('promotion');
            }
            else{
                $error = "Attention année debut plus grand que annee fin";
                $res = $this->redirectToRoute('promotion_ajouter', array('error' => $error));
            }
        }
        elseif ($formReturn->isSubmitted()){
            $res = $this->redirectToRoute('promotion');
        }
        else {
            $res = $this->render('promotion/ajoutPromotion.html.twig', [
                'formulaire' => $form->createView(),
                'formReturn' => $formReturn->createView(),
                'error' => $error,
                'user' => $user,

            ]);
        }
        
        return $res;
    }
    
    /**
     * @Route("/promotion/modifier/{id}&{error}", name="promotion_modifier")
     */
    public function update(Request $req, int $id, $error): Response {
        
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        
        $repoP = $man->getRepository('App\Entity\Promotion');
        $promo = $repoP->find($id);
        $form = $this->createForm(AjoutPromotionType::class, $promo);
        $form->handleRequest($req);
        
        $formReturn = $this->createForm(ReturnType::class);
        $formReturn->handleRequest($req);

        $user = $this->getUser();

        
        if ($form->isSubmitted()) {
            if ($promo->getAnneeDebut() < $promo->getAnneeFin()) {
                $man->persist($promo);
                $man->flush();
                $res = $this->redirectToRoute('promotion');
            }
            else{
                $error = "Attention année debut plus grand que annee fin";
                $res = $this->redirectToRoute('promotion_modifier' , array('id' => $id, 'error' => $error));
            }
        }
        elseif ($formReturn->isSubmitted()){
            $res = $this->redirectToRoute('promotion');
        }
        else {
            $res = $this->render('promotion/ajoutPromotion.html.twig', [
                'formulaire' => $form->createView(),
                'formReturn' => $formReturn->createView(),
                'error' => $error,
                'user' => $user
            ]);
        }
        
        return $res;
    }
}


