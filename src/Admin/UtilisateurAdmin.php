<?php
/**
 * Created by PhpStorm.
 * User: erolland2018
 * Date: 26/11/2018
 * Time: 15:25
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UtilisateurAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Utilisateur',['class' => 'col-md-9'])
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('email', TextType::class)
            ->add('username',TextType::class)
            ->add('password',PasswordType::class)

            ->add('roles',ChoiceType::class,
                array(
                    'choices' =>array(
                        'USER' =>'ROLE_USER',
                        'ADMIN' => 'ROLE_USER'
                    ),
                    'multiple'=> true
                )
            )
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('lastname')
            ->add('firstname')
            ->add('email')
            ->add('username')
            ->add('password')
            ->add('roles')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper ->addIdentifier('username')
                    ->add('lastname')
                    ->add('firstname')
                    ->add('email')
                    ->add('password')
                    ->add('roles')

        ;
    }
}