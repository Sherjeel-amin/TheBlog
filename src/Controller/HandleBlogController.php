<?php
// src/Controller/HandleBlogController.php

namespace App\Controller;

use App\Entity\Blogs;
use App\Entity\Comments;
use App\Form\BlogEditFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\EntityManagerInterface;

class HandleBlogController extends AbstractController
{
    /**
     * Edit an existing blog post.
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * 
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        // Fetch the blog by ID using the EntityManager
        $blog = $entityManager->getRepository(Blogs::class)->find($id);

        // Check if blog exists and throw an exception if not found
        if (!$blog) {
            throw $this->createNotFoundException('No blog found for id '.$id);
        }

        // Check if the current user is the owner of the blog post
        if ($blog->getUser() !== $this->getUser()) {
            throw new AccessDeniedException('You are not allowed to edit this blog post.');
        }

        $form = $this->createForm(BlogEditFormType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $blog->getId()]);
        }

        return $this->render('blog/edit.html.twig', [
            'form' => $form->createView(),
            'blog' => $blog,
        ]);
    }

    /**
     * Delete an existing blog post.
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * 
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get the blog ID from the route parameter
        $blogId = $request->attributes->get('id');
        // Fetch the blog by ID using the EntityManager
        $blog = $entityManager->getRepository(Blogs::class)->find($blogId);

        // Check if blog exists and throw an exception if not found
        if (!$blog) {
            throw $this->createNotFoundException('No blog found for id '.$blogId);
        }

        // Check the CSRF token validity
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            // Fetch and delete all comments associated with the blog
            $comments = $entityManager->getRepository(Comments::class)->findBy(['blog' => $blog]);
            foreach ($comments as $comment) {
                $entityManager->remove($comment);
            }

            // Remove the blog
            $entityManager->remove($blog);
            $entityManager->flush();

            return $this->redirectToRoute('blog_list');
        }

        return $this->redirectToRoute('blog_show', ['id' => $blog->getId()]);
    }
}
