<?php

namespace App\Controller;

use App\Entity\DocModele;
use App\Entity\Stage;
use App\Entity\Etat;
use App\Entity\Professionnel;
use App\Form\StageAjoutType;
use App\Form\StageListeType;
use App\Form\StageModifierType;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\ODText;
use PhpOffice\PhpWord\Writer\PDF\DomPDF;
use PHPUnit\TextUI\XmlConfiguration\Php;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use NcJoes\OfficeConverter\OfficeConverter;


class StageController extends AbstractController {
    
    /**
     * @Route("/stage", name="stage_liste")
     */
    public function list(Request $req): Response {
        $doc = $this->getDoctrine();
        $man = $doc->getManager();
        $repoS = $man->getRepository('\App\Entity\Stage');
        $stage_list = $repoS->findAll();
        $user = $this->getUser();
        $response=$this->render('stage/liste.html.twig', [
            'liste_stage'=>$stage_list,
            'user' => $user,
        ]);
        return $response;
    }
    
    
    /**
     * @Route("/stage/ajouter", name="stage_ajouter")
     */
    public function add(Request $req): Response {
        $stage = new Stage();
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repoEnt = $man->getRepository('App\Entity\Entreprise');
        $ent_liste = $repoEnt->findAll();

        $user = $this->getUser();

        $entreprise_id = null;
        $professionnel_liste = null;
        $isEntSubmitted = false;
        if ($req->get('entreprise') != null) {
            $entreprise_id = $req->get('entreprise');
            $entreprise = $repoEnt->find($entreprise_id);
            $stage->setEntreprise($entreprise);
            $repoPro = $man->getRepository('App\Entity\Professionnel');
            $professionnel_liste = $repoPro->findBy(['entreprise' => $entreprise_id]);
            $isEntSubmitted = true;
        }
        $repoE = $man->getRepository('App\Entity\Etudiant');
        $etudiant = $repoE->findBy(['login' => $user->getId()]);
        $isProf = false;
        $etu_liste = $etudiant;
        foreach ($user->getRoles() as $role) {
            if ($role == 'ROLE_PROFESSEUR') {
                $isProf = true;
            }
        }
        if ($isProf) {
            $etu_liste = $repoE->findAll();
        }
        $repoProf = $man->getRepository('App\Entity\Professeur');
        $prof_liste = $repoProf->findAll();
        
        
        /*var_dump(empty($professionnel_liste));
        exit;*/
        $empty_prof = false;
        if (empty($professionnel_liste && $isEntSubmitted)) {
            $empty_prof = true;
        }
            
        $form = $this->createForm(StageAjoutType::class, $stage, ['etu_liste' => $etu_liste,  'prof_liste' => $prof_liste, 'professionnel_liste' => $professionnel_liste]);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $stage->setDateCreation(new \DateTime());
            $repoEtat = $man->getRepository('App\Entity\Etat');
            $etat = $repoEtat->find(1);
            $stage->setEtat($etat);
            $man->persist($stage);
            $man->flush();
            $res = $this->redirectToRoute('stage_liste');
        } else {
            $res = $this->render('stage/ajout.html.twig', [
                'formulaire' => $form->createView(),
                'user' => $user,
                'liste_ent' => $ent_liste,
                'title' => 'Ajouter',
                'entreprise' => $empty_prof,
                'ent_submit' => $isEntSubmitted,
            ]);
        }
        return $res;
    }
    
    
    /**
     * @Route("/stage/afficher/{id}", name="stage_afficher")
     */
    public function afficher(Request $req, $id): Response {
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repos = $man->getRepository('App\Entity\Stage');
        $stage = $repos->find($id);
        
        $user = $this->getUser();
        
        $res = $this->render('stage/afficher.html.twig', [
            'stage' => $stage,
            'user' => $user,
        ]);
        return $res;
    }
    
    /**
     * @Route("/stage/modifier/{id}", name="stage_modifier")
     */
    public function update(Request $req, int $id): Response {
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repoS = $man->getRepository('App\Entity\Stage');
        $stage = $repoS->find($id);
        $repoEnt = $man->getRepository('App\Entity\Entreprise');
        $ent_liste = $repoEnt->findAll();
        
        $user = $this->getUser();
        
        $entreprise_id = $repoEnt->find($stage->getEntreprise()->getId())->getId();
        
        $professionnel_liste = null;
        $isEntSubmitted = false;
        if ($req->get('entreprise') != null) {
            $entreprise_id = $req->get('entreprise');
            $entreprise = $repoEnt->find($entreprise_id);
            $stage->setEntreprise($entreprise);
            $repoPro = $man->getRepository('App\Entity\Professionnel');
            $professionnel_liste = $repoPro->findBy(['entreprise' => $entreprise_id]);
            $isEntSubmitted = true;
        }
        $empty_prof = false;
        if (empty($professionnel_liste)) {
            $empty_prof = true;
        }
        $repoE = $man->getRepository('App\Entity\Etudiant');
        $etudiant = $repoE->findBy(['login' => $user->getId()]);
        $isProf = false;
        $etu_liste = $etudiant;
        foreach ($user->getRoles() as $role) {
            if ($role == 'ROLE_PROFESSEUR') {
                $isProf = true;
            }
        }
        if ($isProf) {
            $etu_liste = $repoE->findAll();
        } else {
            if ($stage->getEtudiant()->getId() != $user->getId()) {
                return $this->redirectToRoute('stage_liste');
            }
        }
        
        $repoProf = $man->getRepository('App\Entity\Professeur');
        $prof_liste = $repoProf->findAll();
        $repoEtat = $man->getRepository('App\Entity\Etat');
        $etat_liste = $repoEtat->findAll();
        $form = $this->createForm(StageModifierType::class, $stage, ['etat_liste' => $etat_liste, 'etu_liste' => $etu_liste,  'prof_liste' => $prof_liste, 'professionnel_liste' => $professionnel_liste]);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $stage->setDateCreation(new \DateTime());
            $man->persist($stage);
            $man->flush();
            $res = $this->redirectToRoute('stage_liste');
        } else {
            $res = $this->render('stage/ajout.html.twig', [
                'formulaire' => $form->createView(),
                'user' => $user,
                'id_stage' => $id,
                'liste_ent' => $ent_liste,
                'title' => 'Modifier',
                'entreprise' => $empty_prof,
                'ent_submit' => $isEntSubmitted,
            ]);
        }
        return $res;
    }

    /**
     * @Route("/stage/supprimer/{id}", name="stage_supprimer")
     */
    public function delete(Request $req, int $id): Response {
        $doct = $this->getDoctrine();
        $man = $doct->getManager();
        $repos = $man->getRepository('App\Entity\Stage');
        $stage = $repos->find($id);
        $man->remove($stage);
        $man->flush();
        $res = $this->redirectToRoute('stage_liste');
        return $res;
    }

    /**
     * @Route("/stage/conv/{id}", name="stage_conv")
     */
    public function genererConv(int $id): Response {
        $doc = $this->getDoctrine();
        $man = $doc->getManager();
        $repoS = $man->getRepository('App\Entity\Stage');

        $stage = $repoS->find($id);

        $user = $this->getUser();
        
        $isProf = false;
        foreach ($user->getRoles() as $role) {
            if ($role == 'ROLE_PROFESSEUR') {
                $isProf = true;
            }
        }
        if (!$isProf) {
            $stage_verif = $repoS->findOneBy(['etudiant' => $user->getId()]);
            $id_stage = $stage_verif->getIdStage();
            if ($id != $id_stage && !$isProf) {
                return $this->redirectToRoute('stage_liste');
            }
        }
        
        foreach(scandir($this->getParameter('kernel.project_dir') . '/public/') as $f) {
            if (preg_match("/^convention_template_.*\.pdf$/", $f)) {
                unlink($this->getParameter('kernel.project_dir') . '/public/' . $f);
            }
        }

        exec('unoconv -f docx -o ' . $this->getParameter('kernel.project_dir') . '/public/convention_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.docx ' . $this->getParameter('kernel.project_dir') . '/public/file/convention_template.odt');
        //change $fileODT to $file
        $fileODT = $this->getParameter('kernel.project_dir') . '/public/convention_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.docx';
        
        $templateProcessorConvention = new TemplateProcessor($fileODT);

        $templateProcessorConvention->setValue('nom_entreprise', $stage->getEntreprise()->getNomEntreprise());
        $templateProcessorConvention->setValue('adresse_entreprise', $stage->getEntreprise()->getAdresseEntreprise());
        $templateProcessorConvention->setValue('code_postal_entreprise', $stage->getEntreprise()->getVille()->getCodePostal());
        $templateProcessorConvention->setValue('tel_entreprise', $stage->getEntreprise()->getTelephoneEntreprise());
        $templateProcessorConvention->setValue('nom_ville_entreprise', $stage->getEntreprise()->getVille()->getNomVille());
        $templateProcessorConvention->setValue('prenom_professionnel', $stage->getTuteur()->getPrenomProfessionnel());
        $templateProcessorConvention->setValue('nom_professionnel', $stage->getTuteur()->getNomProfessionnel());
        $templateProcessorConvention->setValue('fonction_professionnel', $stage->getTuteur()->getProfessionProfessionnel());
        $templateProcessorConvention->setValue('tel_professionnel', $stage->getTuteur()->getTelephoneProfessionnel());
        $templateProcessorConvention->setValue('mail_professionnel', $stage->getTuteur()->getMailProfessionnel());
        $templateProcessorConvention->setValue('prenom_etu', $stage->getEtudiant()->getPrenom());
        $templateProcessorConvention->setValue('nom_etu', $stage->getEtudiant()->getNom());
        $templateProcessorConvention->setValue('date_naissance_etu', $stage->getEtudiant()->getDateNaissance()->format('d/m/Y'));
        $templateProcessorConvention->setValue('nom_ville_etu', $stage->getEtudiant()->getVille()->getNomVille());
        $templateProcessorConvention->setValue('code_postal_etu', $stage->getEtudiant()->getVille()->getCodePostal());
        $templateProcessorConvention->setValue('prof_referent_stage', $stage->getProfesseur()->getPrenom() . ' ' . $stage->getProfesseur()->getNom());
        $templateProcessorConvention->setValue('mail_professeur', $stage->getProfesseur()->getMail());
        $fileName = 'convention_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.odt';
        $templateProcessorConvention->saveAs($fileName);

        exec('unoconv -f pdf -o ' . $this->getParameter('kernel.project_dir') . '/public/convention_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.pdf ' . $this->getParameter('kernel.project_dir') . '/public/convention_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.odt');

        foreach(scandir($this->getParameter('kernel.project_dir') . '/public/') as $f) {
            if (preg_match("/^convention_template_.*\.docx$/", $f)) {
                unlink($this->getParameter('kernel.project_dir') . '/public/' . $f);
            }
            if (preg_match("/^convention_template_.*\.odt$/", $f)) {
                unlink($this->getParameter('kernel.project_dir') . '/public/' . $f);
            }
        }
        
        $response = new BinaryFileResponse($this->getParameter('kernel.project_dir') . '/public/' . basename('convention_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.pdf'), $status = 200, [header('Content-Disposition: attachment; filename="' . 'convention_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.pdf"')]);

        return $response;
    }

    /**
     * @Route("/stage/lettre/{id}", name="stage_lettre")
     */
    public function genererLettre(int $id): Response {
        $doc = $this->getDoctrine();
        $man = $doc->getManager();
        $repoS = $man->getRepository('App\Entity\Stage');

        $stage = $repoS->find($id);
        
        $user = $this->getUser();
        
        $isProf = false;
        foreach ($user->getRoles() as $role) {
            if ($role == 'ROLE_PROFESSEUR') {
                $isProf = true;
            }
        }
        if (!$isProf && $stage->getEtudiant()->getId() != $user->getId()) {
            return $this->redirectToRoute('stage_liste');
        }

        foreach(scandir($this->getParameter('kernel.project_dir') . '/public/') as $f) {
            if (preg_match("/^lettresio_template_.*\.pdf$/", $f)) {
                unlink($this->getParameter('kernel.project_dir') . '/public/' . $f);
            }
        }

        exec('unoconv -f docx -o ' . $this->getParameter('kernel.project_dir') . '/public/lettresio_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.docx ' . $this->getParameter('kernel.project_dir') . '/public/file/lettresio_template.odt');
        
        $fileODT = $this->getParameter('kernel.project_dir') . '/public/lettresio_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.docx';
        
        $templateProcessorLettre = new TemplateProcessor($fileODT);

        $date = new \DateTime();
        $templateProcessorLettre->setValue('Entreprise', $stage->getEntreprise()->getNomEntreprise());
        $templateProcessorLettre->setValue('TitreRep', $stage->getTuteur()->getTitreProfessionnel());
        $templateProcessorLettre->setValue('PrenomRep', $stage->getTuteur()->getPrenomProfessionnel());
        $templateProcessorLettre->setValue('NomRep', $stage->getTuteur()->getNomProfessionnel());
        $templateProcessorLettre->setValue('Ad1Ent', $stage->getEntreprise()->getAdresseEntreprise());
        $templateProcessorLettre->setValue('Ad2Ent', $stage->getEntreprise()->getComplementAdresseEntreprise());//
        $templateProcessorLettre->setValue('CPEnt', $stage->getEntreprise()->getVille()->getCodePostal());
        $templateProcessorLettre->setValue('VilleEnt', $stage->getEntreprise()->getVille()->getNomVille());
        $templateProcessorLettre->setValue('DateConvention', date('d/m/Y', $date->getTimestamp()));
        $templateProcessorLettre->setValue('PrenomEtu', $stage->getEtudiant()->getPrenom());
        $templateProcessorLettre->setValue('NomEtu', $stage->getEtudiant()->getNom());
        $fileName = 'lettresio_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.docx';
        $templateProcessorLettre->saveAs($fileName);
        
        exec('unoconv -f pdf -o ' . $this->getParameter('kernel.project_dir') . '/public/lettresio_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.pdf ' . $this->getParameter('kernel.project_dir') . '/public/lettresio_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.docx');

        foreach(scandir($this->getParameter('kernel.project_dir') . '/public/') as $f) {
            if (preg_match("/^lettresio_template_.*\.docx$/", $f)) {
                unlink($this->getParameter('kernel.project_dir') . '/public/' . $f);
            }
            if (preg_match("/^lettresio_template_.*\.odt$/", $f)) {
                unlink($this->getParameter('kernel.project_dir') . '/public/' . $f);
            }
        }
        
        $response = new BinaryFileResponse($this->getParameter('kernel.project_dir') . '/public/' . basename('lettresio_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.pdf'), $status = 200, [header('Content-Disposition: attachment; filename="' . 'lettresio_template_' . $stage->getEtudiant()->getNom() . '_' . $stage->getEtudiant()->getPrenom() . '.pdf"')]);

        return $response;
    }
}

?>