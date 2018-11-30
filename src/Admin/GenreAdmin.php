<?php
/**
 * Created by PhpStorm.
 * User: erolland2018
 * Date: 26/11/2018
 * Time: 13:52
 */

namespace App\Admin;

use App\Entity\Genre;
use App\Entity\TypeMedia;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GenreAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Genre',['class' => 'col-md-9'])
            ->add('name', TextType::class)
                    ->add('type',EntityType::class, [
                'class' => TypeMedia::class,
                'choice_label' => 'name',]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name')
            ->add('type.name')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
    }

    public function toString($object)
    {
        return $object instanceof Genre
            ? $object->getName()
            : 'Genre'; // shown in the breadcrumb on the create view
    }

}