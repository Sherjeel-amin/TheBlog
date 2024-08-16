<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/api/register", name="api_register", methods={"POST"})
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ): JsonResponse {
        // Decode JSON content sent from Vue.js frontend
        $data = json_decode($request->getContent(), true);

        // Create a new User entity
        $user = new User();
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setGender($data['gender']);
        $user->setBio($data['bio']);

        // Validate entity fields
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['success' => false, 'errors' => $errorMessages], 400);
        }

        // Check if a user with the same email already exists
        $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
        if ($existingUser) {
            return new JsonResponse(['success' => false, 'message' => 'This email is already registered.'], 400);
        }

        // Hash and set the user's password
        $user->setPassword($passwordEncoder->encodePassword($user, $data['password']));

        // Persist and save the user to the database
        $entityManager->persist($user);
        $entityManager->flush();

        // Return success response
        return new JsonResponse(['success' => true, 'message' => 'Registration successful'], 201);
    }
}
