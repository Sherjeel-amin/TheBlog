<?php
// src/Controller/CommentsController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comments;
use App\Entity\Blogs;
use App\Form\CommentType;

class CommentsController extends AbstractController
{
    /**
     * Function to add a comment to the post
     * 
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * 
     * @return Response 
     */    
    public function addComment(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        // Fetch the blog by ID using the EntityManager
        $blog = $entityManager->getRepository(Blogs::class)->find($id);

        // Check if the blog entity exists
        if (!$blog) {
            throw $this->createNotFoundException('Blog post not found');
        }

        // Get the currently logged-in user
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Create a new comment and set its properties
        $comment = new Comments();
        $comment->setBlog($blog);
        $comment->setUser($user);
        $comment->setCreatedAt(new \DateTime());

        // Create and handle the form
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the comment using the EntityManager
            $entityManager->persist($comment);
            $entityManager->flush();

            // Redirect to the blog post page after successful submission
            return $this->redirectToRoute('blog_show', ['id' => $id]);
        }

        // Redirect to the blog post page in case of form submission failure
        return $this->redirectToRoute('blog_show', ['id' => $id]);
    }
}
