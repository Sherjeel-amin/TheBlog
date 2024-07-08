<?php
// src/Controller/RegistrationController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationFormType;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
/**
     * Handles user registration.
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */

    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if a user with the same email already exists
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

            if ($existingUser) {
                $this->addFlash('error', 'This email is already registered.');
            } else {
                // Hash the password
                $hashedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);

                // Set timestamps for user creation and update
                $user->setCreatedAt(new \DateTime());
                $user->setUpdatedAt(new \DateTime());

                // Persist the user entity
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'User registered successfully!');

                // Redirect to login page or any other route
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
