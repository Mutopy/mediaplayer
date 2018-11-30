<?php
/**
 * Created by PhpStorm.
 * User: erolland2018
 * Date: 26/11/2018
 * Time: 15:25
 */

namespace App\Admin;

use App\Entity\Utilisateur;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UtilisateurAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Utilisateur',['class' => 'col-md-9'])
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('email', EmailType::class)
            ->add('username',TextType::class)
            ->add('password',PasswordType::class)

            ->add('roles',ChoiceType::class,
                array(
                    'choices' =>array(
                        'USER' =>'ROLE_USER',
                        'ADMIN' => 'ROLE_ADMIN'
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
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    public function prePersist($object) {
        $plainPassword = $object->getPassword();
        $container = $this->getConfigurationPool()->getContainer();
        $encoder = $container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($object, $plainPassword);
        $object->setPassword($encoded);
    }

    public function toString($object)
    {
        return $object instanceof Utilisateur
            ? $object->getUsername()
            : 'Utilisateur'; // shown in the breadcrumb on the create view
    }

}