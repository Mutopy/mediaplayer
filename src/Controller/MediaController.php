<?php
/**
 * Created by PhpStorm.
 * User: maliaga2018
 * Date: 26/11/2018
 * Time: 14:10
 */

namespace App\Controller;


use App\Entity\Genre;
use App\Entity\Media;
use App\Form\MediaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends Controller
{
    /**
     * @Route("/media/", name="media_list")
     */
    public function list(EntityManagerInterface $em) {
        $medias = $em->getRepository(Media::class)->findAll();

        $params = array(
            "list" => $medias
        );

        return $this->render('media/list.html.twig', $params);
    }

    /**
     * @Route("/media/create", name="media_create")
     */
    public function create(Request $request, EntityManagerInterface $em) {
        /*$media = new Media();
        $form = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($media);
            $em->flush();

            $this->redirect('media_list');
        }*/

        $form = $this->createFormBuilder()
            ->add('file_media', FileType::class)
            ->add('file_picture', FileType::class)
            ->add('description', TextType::class, array(
                'attr' => array('class' =>'form-control')
            ))
            ->add('genre', EntityType::class, array(
                'class' => Genre::class,
                'choice_label' => 'name',
            ))
            ->add('Submit', SubmitType::class, array(
                'attr' => array('class' =>'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $nameMedia = $request->files->all()["form"]["file_media"]->getClientOriginalName();
            $namePicture = $request->files->all()["form"]["file_picture"]->getClientOriginalName();
            $media = new Media();
            $media->setName(explode(".",$nameMedia)[0]);
            $media->setDateCreated(new \DateTime());
            $media->setDescription($form->get('description')->getViewData());
            $media->setGenre($form->get('genre')->getData());
            $media->setExtension(explode(".",$nameMedia)[1]);
            $media->setPicture($namePicture);
            $media->setUtilisateur($this->getUser());

            //dump($this->get('kernel')->getRootDir() . '\..\public\medias');

            /*$em->persist($media);
            $em->flush();*/

            $request->files->all()["form"]["file_media"]->move(
                $this->get('kernel')->getRootDir() . '\..\public\medias',
                $request->files->all()["form"]["file_media"]->getClientOriginalName()
            );

            //$this->redirect('media_list');
        }

        return $this->render('media/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}