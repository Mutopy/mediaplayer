<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Media;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder
            ->add('name', TextType::class, array(
                'attr' => array('class' =>'form-control')
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array('class' =>'form-control')
            ))
            ->add('dateCreated')
            ->add('picture', TextType::class, array(
                'attr' => array('class' =>'form-control')
            ))
            ->add('extension', TextType::class, array(
                'attr' => array('class' =>'form-control')
            ))
            ->add('genre', EntityType::class, array(
                'class' => Genre::class,
                'choice_label' => 'name',
            ))
            ->add('Submit', SubmitType::class, array(
                'attr' => array('class' =>'btn btn-primary mt-3')
            ))
        ;*/
        $builder
            ->add('file_media', FileType::class, array(
                'mapped' => false,
                'required' => false,
                'label' => 'Média'
            ))
            ->add('file_picture', FileType::class, array(
                'mapped' => false,
                'required' => false,
                'label' => 'Image'
            ))
            ->add('description', TextType::class, array(
                'attr' => array('class' =>'form-control')
            ))
            ->add('genre', EntityType::class, array(
                'attr' => array('class' =>'form-control'),
                'class' => Genre::class,
                'group_by' => function($choiceValue, $key, $value) {
                    return $choiceValue->getType()->getName();
                },
                'choice_label' => 'name',
            ))
            ->add('submit', SubmitType::class, array(
                'attr' => array('class' =>'btn btn-primary mt-3'),
                'label' => 'Envoyer'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
