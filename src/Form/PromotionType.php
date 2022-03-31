<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Controller\PromotionController;
use App\Entity\Promotion;
use Symfony\Component\Routing\Annotation\Route;


class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $promo_liste = $options['promo_liste'];
        
        $builder
            ->add('promo_liste', ChoiceType::class, ['label' => 'promo : ', 'choices' => [$promo_liste], 'choice_label' => 'nom'])
            ->add('bouton_ajout', SubmitType::class, ['label' => 'Ajouter'])
            ->add('bouton_modif', SubmitType::class, ['label' => 'Modifier'])
            ->add('bouton_supp', SubmitType::class, ['label' => 'Supprimer'])
            ->add('bouton_return', SubmitType::class, ['label' => 'retour'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'promo_liste' => array(),
        ]);
    }
}
