<?php
/**
 * Created by PhpStorm.
 * User: maliaga2018
 * Date: 26/11/2018
 * Time: 12:05
 */

namespace App\Controller;


use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home() {
        $params = array(
            "content" => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sem dolor, iaculis nec fermentum sed, luctus a dolor. Fusce vestibulum aliquet aliquet. Vestibulum magna dolor, consectetur malesuada iaculis quis, elementum non ipsum. Pellentesque et nibh purus. Nunc at tempus nisi. Cras at efficitur risus, a tincidunt urna. Quisque consectetur vitae magna sed fringilla. Nunc id consequat est. Donec elementum nunc vehicula leo posuere, ac interdum magna pretium. Nulla et imperdiet justo.'
        );

        return $this->render('main/home.html.twig', $params);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error
        ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $endoder, EntityManagerInterface $em) {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $pass = $endoder->encodePassword($user, $user->getPassword());
            $user->setPassword($pass);
            $user->setRoles(['ROLE_USER']);

            $em->persist($user);
            $em->flush();

            $this->redirect('login');
        }

        return $this->render('main/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {

    }
}