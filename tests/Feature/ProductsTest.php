<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductsTest extends WebTestCase
{
    public function testProducts()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/products');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'All Products');

        $this->assertCount(3, $crawler->filter('div.card'));

        $link = $crawler->filter('a.btn')->eq(0)->link();
        $crawler = $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertNotEquals('http://localhost/products', $crawler->getUri());
        $this->assertEquals('Katze!', $crawler->filter('h1')->eq(0)->text());
    }
}
