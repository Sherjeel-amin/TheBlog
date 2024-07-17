<?php
// src/Controller/BlogController.php
namespace App\Controller;

use App\Entity\Blogs;
use App\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BlogsRepository;
use Symfony\Component\Security\Core\Security;

class BlogController extends AbstractController
{

    private $blogRepository;

    public function new(Request $request, Security $security): Response
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

            // Get the entity manager
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

    public function list(): Response
    {
        // Fetch all blog posts
        $blogs = $this->getDoctrine()->getRepository(Blogs::class)->findAll();

        return $this->render('blog/list.html.twig', [
            'blogs' => $blogs,
        ]);
    }

    public function myBlogs(Security $security): Response
    {
        // Fetch blog posts by the logged-in user
        $user = $security->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to view your blog posts.');
        }

        $blogs = $this->getDoctrine()->getRepository(Blogs::class)->findBy(['user' => $user]);

        return $this->render('blog/my_blogs.html.twig', [
            'blogs' => $blogs,
        ]);
    }

   

    public function __construct(BlogsRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function show(int $id): Response
    {
        $blog = $this->blogRepository->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('The blog does not exist');
        }

        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }
}
