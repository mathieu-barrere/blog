<?php

namespace App\Tests\Unit;

use App\Entity\Article;
use Faker\Factory;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testEmail(): void
    {
        $faker = Factory::create();
        $email = $faker->email();

        $response = $this->user->setEmail($email);

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals($email, $this->user->getEmail());
    }

    public function testUsername(): void
    {
        $faker = Factory::create();
        $email = $faker->email();

        $response = $this->user->setEmail($email);
        
        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals($email, $this->user->getUsername());
    }

    public function testRoles(): void
    {
        $roles = ['ROLE_ADMIN'];

        $response = $this->user->setRoles($roles);

        $this->assertInstanceOf(User::class, $response);
        $this->assertContains('ROLE_ADMIN', $this->user->getRoles());
        $this->assertContains('ROLE_USER', $this->user->getRoles());
    }

    public function testPassword(){

        $faker = Factory::create();
        $password = $faker->password();

        $response = $this->user->setPassword($password);

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals($password, $this->user->getPassword());
    }

public function testAddRemoveArticle(){

        $article = new Article();

        $response = $this->user->addArticle($article);

        $this->assertInstanceOf(User::class, $response);
        $this->assertCount(1, $this->user->getArticles());
        $this->assertTrue($this->user->getArticles()->contains($article));

        $response = $this->user->removeArticle($article);

        $this->assertInstanceOf(User::class, $response);
        $this->assertCount(0, $this->user->getArticles());
        $this->assertFalse($this->user->getArticles()->contains($article));
    }

}
