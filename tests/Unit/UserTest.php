<?php

namespace App\Tests\Unit;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Tests\Unit\HelperTrait;

class UserTest extends KernelTestCase
{
    use HelperTrait;

    private $user;

    public function testValidEntity(): void
    {
        $user = $this->getValidEntity();
        $this->assertInstanceOf(User::class, $user);
        $this->validatorHasErrors($user, 0);
    }

    public function testInvalidEmail(): void
    {
        $user = $this->getValidEntity()->setEmail('invalid');
        $this->assertInstanceOf(User::class, $user);
        $this->validatorHasErrors($user, 1);
    }

    public function testInvalidBlankEmail(): void
    {
        $user = $this->getValidEntity()->setEmail('');
        $this->assertInstanceOf(User::class, $user);
        $this->validatorHasErrors($user, 1);
    }

    public function testUserIdentifier(): void
    {
        $faker = Factory::create();
        $user = $this->getValidEntity();
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user->getEmail(), $user->getUserIdentifier());
    }

    public function testValidRoles(): void
    {
        $roles = ['ROLE_ADMIN'];

        $user = $this->getValidEntity()->setRoles($roles);
        $this->validatorHasErrors($user, 0);

        $this->assertInstanceOf(User::class, $user);
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
        $this->assertContains('ROLE_USER', $user->getRoles());
    }

    public function testAddRemoveArticle(){

        $article = new Article();
        $user = new User();

        $response = $user->addArticle($article);

        $this->assertInstanceOf(User::class, $response);
        $this->assertCount(1, $user->getArticles());
        $this->assertTrue($user->getArticles()->contains($article));

        $response = $user->removeArticle($article);

        $this->assertInstanceOf(User::class, $response);
        $this->assertCount(0, $user->getArticles());
        $this->assertFalse($user->getArticles()->contains($article));
    }

    public function getValidEntity(): User
    {
        $faker = Factory::create();

        return (new User())
        ->setEmail($faker->email())
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($faker->password());
    }

}
