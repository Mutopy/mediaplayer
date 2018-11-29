<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, array(
                'attr' => array('class' =>'form-control', 'autocomplete' => 'disabled'),
                'label' => 'Nom'
            ))
            ->add('firstname', TextType::class, array(
                'attr' => array('class' =>'form-control', 'autocomplete' => 'disabled'),
                'label' => 'Prénom'
            ))
            ->add('email', TextType::class, array(
                'attr' => array('class' =>'form-control', 'autocomplete' => 'disabled'),
                'label' => 'Email'
            ))
            ->add('username', TextType::class, array(
                'attr' => array('class' =>'form-control', 'autocomplete' => 'disabled'),
                'label' => 'Nom d\'utilisateur'
            ))
            ->add('password', PasswordType::class, array(
                'attr' => array('class' =>'form-control', 'autocomplete' => 'disabled'),
                'label' => 'Mot de passe'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
