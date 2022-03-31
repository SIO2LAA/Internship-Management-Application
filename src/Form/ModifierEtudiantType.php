<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Ville;
use App\Entity\UserLogin;
use App\Entity\Promotion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ModifierEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $liste_ville = $options['liste_ville'];
        $liste_promotion = $options['liste_promotion'];
        $liste_specialite = $options['liste_specialite'];
        
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom', 'required' => false])
            ->add('prenom', TextType::class, ['label' => 'Prénom', 'required' => false])
            ->add('mail', EmailType::class, ['label' => 'Email', 'required' => false])
            ->add('adresse', TextType::class, ['label' => 'Adresse', 'required' => false])
            ->add('complementAdresse', TextType::class, ['label' => "Compl�ment d'adresse", 'required' => false])
            ->add('telephone', TextType::class, ['label' => 'Téléphone', 'required' => false])
            ->add('dateNaissance', DateType::class, ['label' => 'Date de Naissance', 'years' => range(date('Y')-50, date('Y')+50), 'required' => false])
            ->add($builder->create('login', FormType::class, ['data_class' => UserLogin::class])
                ->add('identifiant', TextType::class, ['required' => false])
                /*->add('password', PasswordType::class, ['required' => false])*/)
            /*->add($builder->create('ville', FormType::class, ['data_class' => Ville::class])
                ->add('codePostal', TextType::class, ['label' => 'Code Postal'])
                ->add('nomVille', TextType::class, ['label' => 'Nom de la ville']))*/
            ->add('ville', ChoiceType::class, ['choices' => [$liste_ville], 'choice_label' => 'nomVille'])
            ->add('promotion', ChoiceType::class, ['choices' => [$liste_promotion], 'choice_label' => 'nom'])
            ->add('specialite', ChoiceType::class, ['choices' => [$liste_specialite], 'choice_label' => 'specialite'])
            ->add('valider', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
            'liste_ville' => array(),
            'liste_promotion' => array(),
            'liste_specialite' => array(),
        ]);
    }
}
