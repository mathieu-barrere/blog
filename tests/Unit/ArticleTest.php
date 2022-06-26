<?php

namespace App\Tests\Unit;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    private $article;

    protected function setUp(): void
    {
        $this->article = new Article();
    }

    public function testTitle(): void
    {
        $faker = Factory::create();
        $content = $faker->sentence();

        $response = $this->article->setTitle($content);

        $this->assertInstanceOf(Article::class, $response);
        $this->assertEquals($content, $this->article->getTitle());
    }

    public function testContent(): void
    {
        $faker = Factory::create();
        $content = $faker->text();

        $response = $this->article->setContent($content);
        
        $this->assertInstanceOf(Article::class, $response);
        $this->assertEquals($content, $this->article->getContent());
    }

    public function testAuthor(): void
    {
        $author = new User();

        $response = $this->article->setAuthor($author);

        $this->assertInstanceOf(Article::class, $response);
        $this->assertSame($author, $this->article->getAuthor());
    }
}
