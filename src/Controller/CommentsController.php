<?php
// src/Controller/CommentsController.php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentType;
use App\Repository\CommentsRepository;
use App\Repository\BlogsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{
    /**
     * Function to add a comment to the post
     * 
     * @param id
     * @param request
     * @param CommentsRepository
     * @param BlogsRepository
     * 
     * @return Reponse 
     * */    
    public function addComment(Request $request, int $id, CommentsRepository $commentsRepository, BlogsRepository $blogsRepository): Response
    {
        $blog = $blogsRepository->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Blog post not found');
        }

        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $comment = new Comments();
        $comment->setBlog($blog);
        $comment->setUser($user);
        $comment->setCreatedAt(new \DateTime());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $id]);
        }

        return $this->redirectToRoute('blog_show', ['id' => $id]);
    }
}
