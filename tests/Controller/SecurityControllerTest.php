<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class SecurityControllerTest extends WebTestCase
{

    /** @var AbstractDatabaseTool */
    protected $databaseTool;
    protected $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testDisplayLogin(): void
    {
        $this->client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Se connecter');
    }

    public function testSubmitLoginForm(): void
    {
        $this->client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('button', 'Se connecter');
        $this->assertSelectorNotExists('.alert.alert-danger');
    }

    public function testLoginBadCredentials(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertSelectorTextContains('h1', 'Se connecter');

        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'john.doe@test.com',
            'password' => 'password'
        ]);

        $this->client->submit($form);
        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();

        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testSuccessfullLogin(): void
    {
        $this->databaseTool->loadAliceFixture([__DIR__.'/users.yaml']);

        $crawler = $this->client->request('GET', '/login');

        $this->assertSelectorTextContains('h1', 'Se connecter');

        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'john.doe@test.com',
            'password' => 'abcdef'
        ]);

        $this->client->submit($form);
        $this->assertResponseRedirects('/');
    }
   
}
