<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserLoginController extends AbstractController
{
    /**
     * @Route("/user/login", name="user_login")
     */
    public function index(): Response
    {
        return $this->render('user_login/index.html.twig', [
            'controller_name' => 'UserLoginController',
        ]);
    }
}
