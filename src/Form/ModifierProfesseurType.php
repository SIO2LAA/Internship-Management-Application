<?php

namespace App\Form;

use App\Entity\Professeur;
use App\Entity\UserLogin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ModifierProfesseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, ['label' => 'Nom', 'required' => false])
        ->add('prenom', TextType::class, ['label' => 'Prénom', 'required' => false])
        ->add('mail', TextType::class, ['label' => 'Email', 'required' => false])
        ->add($builder->create('login', FormType::class, ['data_class' => UserLogin::class])
            ->add('identifiant', TextType::class, ['required' => false]))
        ->add('valider', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}
