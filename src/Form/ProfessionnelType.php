<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Professionnel;

class ProfessionnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $ent_liste = $options['ent_liste'];

        $builder
        ->add('titreProfessionnel', ChoiceType::class, ['choices' => ['Monsieur' => 'Monsieur', 'Madame' => 'Madame']])
        ->add('nomProfessionnel')
        ->add('prenomProfessionnel')
        ->add('professionProfessionnel')
        ->add('telephoneProfessionnel')
        ->add('mailProfessionnel',EmailType::class)
        ->add('entreprise',ChoiceType::class,['choices'=>[$ent_liste], 'choice_label' => 'nomEntreprise'])
        ->add('bouton',SubmitType::Class,['label'=>'Envoyer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professionnel::class,
            'ent_liste' => array(),
            
        ]);
    }
}
