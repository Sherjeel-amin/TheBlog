<?php
// tests/Controller/AuthControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    public function testLoginWithValidCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/login');

        $form = $crawler->selectButton('Sign in')->form([
            'email' => 'testuser@example.com',
            'password' => 'hashed_password',
        ]);

        $client->submit($form);

        $client->followRedirect();
        // $this->assertResponseRedirects('/'); 
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Welcome to TheBlog');
    }

    public function testLoginWithInvalidCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/login');

        $form = $crawler->selectButton('Sign in')->form([
            'email' => 'invaliduser@example.com',
            'password' => 'invalidpassword',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(302); 
        $this->assertResponseRedirects('/users/login'); 
    }
}
