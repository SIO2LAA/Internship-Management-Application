<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('file', FileType::class, ['label' => 'Fichier CSV Obligatoire', 'mapped' => false, 'required' => false])
        ->add('valider', SubmitType::class, ['label' => 'Valider'])
        ;
         }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
