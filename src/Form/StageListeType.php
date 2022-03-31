<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StageListeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('bouton_ajouter', SubmitType::class, ['label' => 'Ajouter'])
            ->add('bouton_afficher', SubmitType::class, ['label' => 'Afficher'])
            ->add('bouton_supprimer', SubmitType::class, ['label' => 'Supprimer'])
            ->add('bouton_modifier', SubmitType::class, ['label' => 'Modifier'])
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //
        ]);
    }
}
