<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationFormType;
use App\Entity\User;

class RegistrationController extends AbstractController
{

    public function index(Request $request): Response
    {
        // Get the EntityManager using getDoctrine()
        $entityManager = $this->getDoctrine()->getManager();

        // Create a new User instance
        $user = new User();

        // Create the registration form
        $form = $this->createForm(RegistrationFormType::class, $user);

        // Handle the form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if a user with the same email already exists
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

            if ($existingUser) {
                // If user exists, show an error message
                $this->addFlash('error', 'This email is already registered.');
            } else {
                // Set timestamps for user creation and update
                $user->setCreatedAt(new \DateTime());
                $user->setUpdatedAt(new \DateTime());

                // Persist the user entity
                $entityManager->persist($user);
                $entityManager->flush();

                // Show a success message
                $this->addFlash('success', 'User registered successfully!');

                // Redirect to login page or any other route
                // return $this->redirectToRoute('app_login'); 
            }
        }

        // Render the registration form template with the form view
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
