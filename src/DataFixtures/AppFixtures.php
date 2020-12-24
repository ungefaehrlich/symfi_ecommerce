<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setName('Katze!');
        $product->setDescription('Eine Katze, umweltschonend in Papier verpackt!');
        $product->setPrice(1337);
        $product->setStock(42);
        $product->setPicture("http://placekitten.com/g/200/300");
        $product->setIsOffer(true);
        $manager->persist($product);

        $product = new Product();
        $product->setName('Kopfhoerer!');
        $product->setDescription('Kopfhoeher halt');
        $product->setPrice(4200);
        $product->setStock(13);
        $product->setPicture("https://picsum.photos/200/300?random=2");
        $product->setIsOffer(false);
        $manager->persist($product);

        $product = new Product();
        $product->setName('moar crap');
        $product->setDescription('muell');
        $product->setPrice(1000);
        $product->setStock(1);
        $product->setPicture("https://picsum.photos/200/300?random=1");
        $product->setIsOffer(false);
        $manager->persist($product);

        $manager->flush();
    }
}
