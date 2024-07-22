<?php
// src/Controller/HandleBlogController.php

namespace App\Controller;

use App\Entity\Blogs;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\EntityManagerInterface;

class HandleBlogController extends AbstractController
{
    // ... other methods

    /**
     * Delete an existing blog post.
     *
     * @param Request $request The current request object.
     * @param CommentsRepository $commentsRepository The repository for Comment entities.
     * @param EntityManagerInterface $entityManager The entity manager.
     * 
     * @return Response The response object.
     */
    public function delete(Request $request, CommentsRepository $commentsRepository, EntityManagerInterface $entityManager): Response
    {
        // Get the blog ID from the route parameter
        $blogId = $request->attributes->get('id');
        // Fetch the blog by ID using the repository
        $blog = $entityManager->getRepository(Blogs::class)->find($blogId);

        // Check if blog exists and throw an exception if not found
        if (!$blog) {
            throw $this->createNotFoundException('No blog found for id '.$blogId);
        }

        // Check the CSRF token validity
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            // Fetch and delete all comments associated with the blog
            $comments = $commentsRepository->findBy(['blog' => $blog]);
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
