<?php

// src/Controller/AdminController.php
namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */


class AdminController extends EasyAdminController
{
    /**
     * Require ROLE_ADMIN for only this controller method.
     *
     * @IsGranted("ROLE_ADMIN")
     */

    protected function prePersistUserEntity(User $user)
    {
        $encodedPassword = $this->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
    }

    protected function preUpdateUserEntity(User $user)
    {
        if (!$user->getPlainPassword()) {
            return;
        }
        $encodedPassword = $this->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($encodedPassword);
    }

    private function encodePassword($user, $password)
    {
        $passwordEncoderFactory = $this->get('security.encoder_factory');
        $encoder = $passwordEncoderFactory->getEncoder($user);
        return $encoder->encodePassword($password, $user->getSalt());
    }

    /**
     * @Route("/create-user", name="create_user")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // if ($form->isSubmitted()) {

        //     exit(\Doctrine\Common\Util\Debug::dump($user));

        // }

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // exit(\Doctrine\Common\Util\Debug::dump($user));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('easyadmin');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

}
