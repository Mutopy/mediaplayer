<?php
/**
 * Created by PhpStorm.
 * User: erolland2018
 * Date: 26/11/2018
 * Time: 15:25
 */

namespace App\Admin;

use App\Entity\Genre;
use App\Entity\Utilisateur;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MediaAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class)
                    ->add('description', TextType::class)
                    ->add('dateCreated', DateTimeType::class)
                    ->add('picture',TextType::class)
                    ->add('extension',TextType::class)
                    ->add('genre',EntityType::class, [
                        'class' => Genre::class,
                        'choice_label' => 'name',])
                    ->add('utilisateur',EntityType::class, [
                        'class' => Utilisateur::class,
                        'choice_label' => 'username',])
                ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
    }
}