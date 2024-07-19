<?php
// src/Controller/BlogController.php
namespace App\Controller;

use App\Entity\Blogs;
use App\Form\BlogType;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BlogsRepository;
use Symfony\Component\Security\Core\Security;
use App\Repository\CommentsRepository;
use App\Entity\Comments;

class BlogController extends AbstractController
{
    /**
     * Creates a new blog post.
     *
     * @param Request $request
     * @param Security $security
     * @param BlogsRepository $blogRepository
     * 
     * @return Response
     */
    public function new(Request $request, Security $security, BlogsRepository $blogRepository): Response
    {
        $blog = new Blogs();
        $form = $this->createForm(BlogType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the user to the currently logged-in user
            $user = $security->getUser();
            if (!$user) {
                throw $this->createAccessDeniedException('You must be logged in to create a blog post.');
            }
            $blog->setUser($user);

            // Persist the blog post
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            // Redirect to the list of blogs after successful submission
            return $this->redirectToRoute('blog_list');
        }

        return $this->render('blog/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Lists all blog posts.
     *
     * @param BlogsRepository $blogRepository
     * 
     * @return Response
     */
    public function list(BlogsRepository $blogRepository): Response
    {
        // Fetch all blog posts
        $blogs = $blogRepository->findAll();

        return $this->render('blog/list.html.twig', [
            'blogs' => $blogs,
        ]);
    }

    /**
     * Lists the logged-in user's blog posts.
     *
     * @param Security $security
     * @param BlogsRepository $blogRepository
     * 
     * @return Response
     */
    public function myBlogs(Security $security, BlogsRepository $blogRepository): Response
    {
        // Fetch blog posts by the logged-in user
        $user = $security->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to view your blog posts.');
        }

        $blogs = $blogRepository->findBy(['user' => $user]);

        return $this->render('blog/my_blogs.html.twig', [
            'blogs' => $blogs,
        ]);
    }

    /**
     * Shows a single blog post.
     *
     * @param int $id
     * @param BlogsRepository $blogRepository
     * 
     * @return Response
     */

     public function show(int $id, Request $request, BlogsRepository $blogRepository, CommentsRepository $commentsRepository): Response
     {
         // Fetch the blog entity based on the ID from the route parameter
         $blog = $blogRepository->find($id);
     
         // Check if the blog entity exists
         if (!$blog) {
             throw $this->createNotFoundException('No blog post found for id ' . $id);
         }
     
         $comment = new Comments();
         $comment->setBlog($blog);
         $comment->setUser($this->getUser());
         $comment->setCreatedAt(new \DateTime());
     
         $form = $this->createForm(CommentType::class, $comment);
         $form->handleRequest($request);
     
         if ($form->isSubmitted() && $form->isValid()) {
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($comment);
             $entityManager->flush();
     
             return $this->redirectToRoute('blog_show', ['id' => $blog->getId()]);
         }
     
         $comments = $commentsRepository->findBy(['blog' => $blog]);
     
         return $this->render('blog/show.html.twig', [
             'blog' => $blog,
             'commentForm' => $form->createView(),
             'comments' => $comments,
         ]);
     }
    }     