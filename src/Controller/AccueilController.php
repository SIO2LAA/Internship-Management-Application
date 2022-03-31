<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {

        $user = $this->getUser();



        return $this->render('accueil/index.html.twig', [
            'user' => $user,
        ]);
    }
}
