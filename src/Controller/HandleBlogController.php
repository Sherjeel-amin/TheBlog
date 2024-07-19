<?php
// src/Controller/HandleBlogController.php

namespace App\Controller;

use App\Entity\Blogs;
use App\Form\BlogEditFormType;
use App\Repository\BlogsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class HandleBlogController extends AbstractController
{
    /**
     * Edit an existing blog post.
     *
     * @param Request $request The current request object.
     * @param BlogsRepository $blogRepository The repository for Blog entities.
     * @param int $id The ID of the blog to be edited.
     * 
     * @return Response The response object.
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
            // Get the entity manager the "old way"
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
     * @param Request $request The current request object.
     * 
     * @return Response The response object.
     */
    public function delete(Request $request): Response
    {
        // Get the blog ID from the route parameter
        $blogId = $request->attributes->get('id');
        // Fetch the blog by ID using the repository
        $blog = $this->getDoctrine()->getRepository(Blogs::class)->find($blogId);

        // Check if blog exists and throw an exception if not found
        if (!$blog) {
            throw $this->createNotFoundException('No blog found for id '.$blogId);
        }

        // Check if the current user is the owner of the blog post
        if ($blog->getUser() !== $this->getUser()) {
            throw new AccessDeniedException('You are not allowed to delete this blog post.');
        }

        // Check the CSRF token validity
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            // Get the entity manager the "old way"
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blog);
            $entityManager->flush();

            return $this->redirectToRoute('blog_list');
        }

        return $this->redirectToRoute('blog_show', ['id' => $blog->getId()]);
    }
}
