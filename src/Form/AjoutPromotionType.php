<?php

namespace App\Form;

use App\Entity\Promotion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutPromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('anneeDebut')
            ->add('anneeFin')
            ->add('bouton_ajout', SubmitType::class, ['label' => 'Ajouter'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
