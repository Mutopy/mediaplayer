<?php
/**
 * Created by PhpStorm.
 * User: maliaga2018
 * Date: 26/11/2018
 * Time: 14:10
 */

namespace App\Controller;


use App\Entity\Fichier;
use App\Entity\Media;
use App\Entity\TypeMedia;
use App\Form\MediaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends Controller
{
    /**
     * @Route("/media/{id}", name="media_list", defaults={"id"=1}, requirements={"id":"\d+"})
     */
    public function list(TypeMedia $typeMedia, EntityManagerInterface $em) {
        $medias = $em->getRepository(Media::class)->findByType($typeMedia);
        $types = $em->getRepository(TypeMedia::class)->findAll();

        $params = array(
            "list" => $medias,
            "types" => $types,
            "current" => $typeMedia
        );

        return $this->render('media/list.html.twig', $params);
    }

    /**
     * @Route("/media/create", name="media_create")
     */
    public function create(Request $request, EntityManagerInterface $em) {
        $media = new Media();
        $form = $this->createForm(MediaType::class, $media);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $fileMedia = new Fichier($request->files->all()["media"]["file_media"]);
            $filePicture = new Fichier($request->files->all()["media"]["file_picture"]);
            $nameMedia = $fileMedia->getName();
            $namePicture = $filePicture->getName();
            $media = new Media();
            $media->setName(explode(".",$nameMedia)[0]);
            $media->setDateCreated(new \DateTime());
            $media->setDescription($form->get('description')->getViewData());
            $media->setGenre($form->get('genre')->getData());
            $media->setExtension(explode(".",$nameMedia)[1]);
            $media->setPicture($namePicture);
            $media->setUtilisateur($this->getUser());

            $em->persist($media);
            $em->flush();

            $fileMedia->upload(
                $this->get('kernel')->getRootDir() . '\..\public\medias'
            );

            $filePicture->upload(
                $this->get('kernel')->getRootDir() . '\..\public\medias'
            );

            $this->addFlash("success", "Le média a été créé");

            return $this->redirectToRoute('media_manage');
        }

        return $this->render('media/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/media/manage", name="media_manage")
     */
    public function manage(EntityManagerInterface $em) {
        $medias = $em->getRepository(Media::class)->findByUser($this->getUser()->getId());

        $params = array(
            "list" => $medias
        );

        return $this->render('media/manage.html.twig', $params);
    }

    /**
     * @Route("/media/delete/{id}", name="media_delete")
     */
    public function delete(Media $media, EntityManagerInterface $em) {
        $em->remove($media);
        $em->flush();

        $fileSystem = new Filesystem();
        $fileSystem->remove($this->get('kernel')->getRootDir() . '\..\public\medias\\'.$media->getPicture());
        $fileSystem->remove($this->get('kernel')->getRootDir() . '\..\public\medias\\'.$media->getName().".".$media->getExtension());

        $this->addFlash("danger", "Le média a été supprimé");

        return $this->redirectToRoute('media_manage');
    }

    /**
     * @Route("/media/update/{id}", name="media_update")
     */
    public function update(Media $media, Request $request, EntityManagerInterface $em) {
        //$media = new Media();
        $form = $this->createForm(MediaType::class, $media);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $fileMedia = new Fichier($request->files->all()["media"]["file_media"]);
            $filePicture = new Fichier($request->files->all()["media"]["file_picture"]);

            if($fileMedia->getFile() != null) {
                $media->setName(explode(".",$fileMedia->getName())[0]);
                $media->setExtension(explode(".",$fileMedia->getName())[1]);
            }
            $media->setDateCreated(new \DateTime());
            $media->setDescription($form->get('description')->getViewData());
            $media->setGenre($form->get('genre')->getData());
            if($filePicture->getFile() != null) {
                $media->setPicture($filePicture->getName());
            }
            $media->setUtilisateur($this->getUser());

            $em->persist($media);
            $em->flush();

            if($fileMedia->getFile() != null) {
                $fileMedia->upload(
                    $this->get('kernel')->getRootDir() . '\..\public\medias'
                );
            }

            if($filePicture->getFile() != null) {
                $filePicture->upload(
                    $this->get('kernel')->getRootDir() . '\..\public\medias'
                );
            };

            $this->addFlash("warning", "Le média a été modifié");

            return $this->redirectToRoute('media_manage');
        }

        return $this->render('media/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}