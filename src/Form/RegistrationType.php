<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
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
                'attr' => array('class' =>'form-control')
            ))
            ->add('firstname', TextType::class, array(
                'attr' => array('class' =>'form-control')
            ))
            ->add('email', TextType::class, array(
                'attr' => array('class' =>'form-control')
            ))
            ->add('username', TextType::class, array(
                'attr' => array('class' =>'form-control')
            ))
            ->add('password', TextType::class, array(
                'attr' => array('class' =>'form-control')
            ))
            ->add('Submit', SubmitType::class, array(
                'attr' => array('class' =>'btn btn-primary mt-3')
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
