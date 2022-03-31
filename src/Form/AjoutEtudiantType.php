<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Promotion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $liste_promotion = $options['liste_promotion'];

        $builder
            ->add('file', FileType::class, ['label' => 'Fichier CSV Obligatoire', 'mapped' => false, 'required' => true])
            ->add('promotion', ChoiceType::class, ['choices' => $liste_promotion, 'choice_label' => 'nom', 'placeholder' => 'Choisissez une promotion'])
            ->add('valider', SubmitType::class, ['label' => 'Valider'])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'liste_promotion' => array(),
        ]);
    }
}
