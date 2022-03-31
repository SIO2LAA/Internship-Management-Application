<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\EntrepriseType;
use App\Form\VilleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class VilleController extends AbstractController
{
    /**
     * 
     * @Route("/ville", name="ville")
     */
    public function index(): Response
    {
        return $this->render('ville/index.html.twig', [
            'controller_name' => 'VilleController',
        ]);
    }
    
    /**
     * @Route("/ville/liste", name="listeVille")
     */
    public function listVille(): Response
    {
        $doc = $this->getDoctrine();
        $man = $doc->getManager();
        $repo = $man->getRepository('\App\Entity\Ville');
        $list= $repo->findAll();

        $user = $this->getUser();


        $response=$this->render('ville/liste.html.twig', ['liste'=>$list, 'user' => $user
        ]);
        return $response;
    }
    
    /**
     * @Route("/ville/ajouter", name="ville_ajouter")
     */
    public function ajouter(Request $req): Response
    
    {
        /*$ville= new Ville();
        $form = $this -> createForm(VilleType::class, $ville);
        $form->handleRequest($req);
        
        if($form->isSubmitted()){
            $doct = $this->getDoctrine();
            $man = $doct->getManager();
            $man->persist($ville);
            $man->flush();
            $res = $this->redirectToRoute('listeVille');
        }
        else{
            $res = $this->render('ville/ajouter.html.twig',['formulaireVille' => $form->createView()
                
            ]);
        }*/
        
        $form = $this->createForm(VilleType::class);
        $form->handleRequest($req);

        $user = $this->getUser();

        if ($form->isSubmitted()) {
            $doctrine = $this->getDoctrine();
            $manager = $doctrine->getManager();
            $file = $form->get('file');
            $encoders = [new CsvEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);




            foreach ($serializer->decode(file_get_contents($file->getData()), 'csv') as $r) {
                $data = $r;
            }
                
            $ville = (new Ville())
                ->setNomVille($data['nomVille'])
                ->setCodePostal($data['codePostal'])
                ->setNumDepartement($data['numDepartement']);
                
            $manager->persist($ville);
            $manager->flush();
            
            $ret = $this->redirectToRoute('listeVille');
            
        }
        else {
            $ret = $this->render('ville/ajouter.html.twig', ['formulaire' => $form->createView(), 'user' => $user]);
        }
        
        return $ret;
    }
    
   
}
