<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifierEntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    { $ville_liste = $options['listeVille'];
    $specialite_liste=$options['specialiteListe'];
    
    $builder
    ->add('nomEntreprise')
    ->add('ville',ChoiceType::class,['choices'=>[$ville_liste],'choice_label'=>'nomVille'])
    ->add('adresseEntreprise')
    ->add('mailEntreprise',EmailType::class)
    ->add('telephoneEntreprise')
    ->add('specialite',ChoiceType::class,['choices'=>[$specialite_liste],'choice_label'=>'specialite'])
    ->add('bouton',SubmitType::Class,['label'=>'Envoyer'])
    ;
    }

    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Entreprise::class,
            'listeVille' => array(),
            'specialiteListe' => array(),
        ]);
    }
}
