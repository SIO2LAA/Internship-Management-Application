<?php

namespace App\Form;

use App\Entity\UserLogin;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifierPasswordUtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        $builder
            //->add('login', EntityType::class, ['class' => 'App\Entity\UserLogin', 'choice_label' => 'password'])
            ->add($builder->create('login', FormType::class, ['data_class' => UserLogin::class])
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options'  => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Resaisir mot de passe'],
                ]))

            ->add('valider', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
