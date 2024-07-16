<?php
// src/Controller/BlogController.php
namespace App\Controller;

use App\Entity\Blogs;
use App\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class BlogController extends AbstractController
{
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
        }

        return $this->render('blog/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
