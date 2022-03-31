<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StageAjoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $etu_liste = $options['etu_liste'];
        $prof_liste = $options['prof_liste'];
        $professionnel_liste = $options['professionnel_liste'];
        $builder
            ->add('etudiant',ChoiceType::class,['choices'=>[$etu_liste], 'choice_label' => 'nom'])
            ->add('professeur',ChoiceType::class,['choices'=>[$prof_liste], 'choice_label' => 'nom']);
            if (!empty($professionnel_liste)) {
                $builder
                    ->add('tuteur',ChoiceType::class,['choices'=>[$professionnel_liste], 'choice_label' => 'nomProfessionnel'])
                    ->add('signataire',ChoiceType::class,['choices'=>[$professionnel_liste], 'choice_label' => 'nomProfessionnel']);
            }
        $builder
            ->add('dateDebut')
            ->add('dateFin')
            ->add('description')
            ->add('valider', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
            'etu_liste' => array(),
            'prof_liste' => array(),
            'professionnel_liste' => array(),
        ]);
    }
}
