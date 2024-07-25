<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BlogControllerTest extends WebTestCase
{
    // public function testCreateBlogPost(): void
    // {
    //     $client = static::createClient();
        
    //     // Simulate user login
    //     $client->request('POST', '/users/login', [
    //         'email' => 'testuser@example.com',
    //         'password' => 'hashed_password',
    //     ]);

    //     //Check if the user is redirected to the blog creation page
    //     $crawler = $client->request('GET', '/users/blogs');
    //     $this->assertResponseIsSuccessful();
    //     $this->assertSelectorTextContains('h1', 'My Blogs');

    //     //Check if redirection to the blog list page is successful
    //     $this->assertResponseRedirects('/blogs/all');
    //     $client->followRedirect();

    // }

    public function testListBlogs(): void
    {
        $client = static::createClient();
        $client->request('GET', '/blogs/all');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'All Blog Posts');
    }

    // public function testShowBlogPost(): void
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/blogs/3');

    //     $this->assertResponseIsSuccessful();
    //     $this->assertSelectorTextContains('h1', 'TheSpartans'); 
    // }

    // public function testMyBlogs(): void
    // {
    //     $client = static::createClient();
        
    //     // Simulate user login
    //     $client->request('POST', '/users/login', [
    //         'username' => 'sherjeelamin@gmail.com   ',
    //         'password' => 'Sharjeel@123',
    //     ]);

    //     $client->request('GET', '/users/blogs');

    //     $this->assertResponseIsSuccessful();
    //     $this->assertSelectorTextContains('h1', 'My Blogs');
    // }

}
