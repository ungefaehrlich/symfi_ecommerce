<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WelcomeTest extends WebTestCase
{
    public function testWelcome()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Offers');
        $this->assertSelectorTextContains('h1', 'Welcome to the Shop!');
        $this->assertSelectorTextContains('h5.card-title', 'Katze!');
    }
}
