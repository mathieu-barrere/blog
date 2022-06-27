<?php

namespace App\Tests\Unit;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Tests\Unit\HelperTrait;

class ArticleTest extends KernelTestCase
{
    use HelperTrait;

    public function testValidTitle(): void
    {
        $faker = Factory::create();
        $content = $faker->sentence();

        $article = new Article();

        $response = $article->setTitle($content);

        $this->assertInstanceOf(Article::class, $response);
        $this->assertEquals($content, $article->getTitle());
    }

    public function testValidContent(): void
    {
        $faker = Factory::create();
        $content = $faker->text();

        $article = new Article();

        $response = $article->setContent($content);

        $this->assertInstanceOf(Article::class, $response);
        $this->assertEquals($content, $article->getContent());
    }

    public function testValidAuthor(): void
    {
        $author = new User();
        $article = new Article();

        $response = $article->setAuthor($author);

        $this->assertInstanceOf(Article::class, $response);
        $this->assertSame($author, $article->getAuthor());
    }

    public function testValidEntity(): void
    {
        $faker = Factory::create();

        $article = $this->getValidEntity();

        $this->assertInstanceOf(Article::class, $article);
        $this->validatorHasErrors($article, 0);
    }

    public function testInvalidBlankTitle(): void
    {
        $article = $this->getValidEntity()->setTitle('');
        
        $this->assertInstanceOf(Article::class, $article);
        $this->validatorHasErrors($article, 1);
    }

    public function testInvalidBlankContent(): void
    {
        $article = $this->getValidEntity()->setContent('');

        $this->assertInstanceOf(Article::class, $article);
        $this->validatorHasErrors($article, 1);
    }

    public function getValidEntity(): Article
    {
        $faker = Factory::create();

        return (new Article())
        ->setTitle($faker->sentence())
        ->setContent($faker->text())
        ->setAuthor(new User());
    }
}
