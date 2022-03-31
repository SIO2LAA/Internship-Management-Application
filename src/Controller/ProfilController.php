<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /*
      @Route("/profil", name="profil")
     
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }*/
    
     /**
     * @Route("/profil", name="specialiteListe")
     */
    public function listeEntreprise(): Response
    {
            $doc = $this->getDoctrine();
            $man = $doc->getManager();
            $repoPers = $man->getRepository('\App\Entity\Profil');
            $list= $repoPers->findAll();

            $user = $this->getUser();


            $response=$this->render('profil/liste.html.twig', ['liste'=>$list, 'user' => $user]);
            return $response;
    }
}
