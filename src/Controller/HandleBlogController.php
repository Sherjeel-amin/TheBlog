<?php
// src/Controller/HandleBlogController.php

namespace App\Controller;

use App\Entity\Blogs;
use App\Form\BlogEditFormType;
use App\Repository\BlogsRepository;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\EntityManagerInterface;

class HandleBlogController extends AbstractController
{
    // Other methods...

    /**
     * Edit an existing blog post.
     *
     * @param Request $request
     * @param BlogsRepository $blogRepository
     * @param int $id
     * 
     * @return Response
     */
    public function edit(Request $request, BlogsRepository $blogRepository, int $id): Response
    {
        // Fetch the blog by ID using the repository
        $blog = $blogRepository->find($id);

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
            $entityManager = $this->getDoctrine()->getManager();
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
     * @param CommentsRepository $commentsRepository
     * @param EntityManagerInterface $entityManager
     * 
     * @return Response
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
