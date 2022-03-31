<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\UserLogin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifierCompteEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $liste_ville = $options['liste_ville'];

        $builder
            ->add('nom', TextType::class, ['label' => 'Nom', 'required' => false])
            ->add('prenom', TextType::class, ['label' => 'Prénom', 'required' => false])
            ->add('mail', EmailType::class, ['label' => 'Email', 'required' => false])
            ->add('adresse', TextType::class, ['label' => 'Adresse', 'required' => false])
            ->add('complementAdresse', TextType::class, ['label' => "Complément d'adresse", 'required' => false])
            ->add('telephone', TextType::class, ['label' => 'Téléphone', 'required' => false])
            ->add('dateNaissance', DateType::class, ['label' => 'Date de Naissance', 'years' => range(date('Y')-50, date('Y')+50), 'required' => false])
            ->add($builder->create('login', FormType::class, ['data_class' => UserLogin::class])
                ->add('identifiant', TextType::class, ['required' => false]))
            ->add('ville', ChoiceType::class, ['choices' => [$liste_ville], 'choice_label' => 'nomVille'])
            ->add('valider', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
            'liste_ville' => array(),
        ]);
    }
}
