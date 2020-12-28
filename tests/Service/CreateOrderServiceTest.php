<?php

namespace App\Tests\Service;

use App\Entity\Address;
use App\Entity\Product;
use App\Service\CreateOrderService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateOrderServiceTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->em->close();
        $this->em = null;
    }

    private function createAddress(): Address
    {
        $address = new Address();
        $address->setSalutation('Mr');
        $address->setFirstname('invoice');
        $address->setLastname('Test');
        $address->setStreet('Test');
        $address->setCity('Test');
        $address->setPostcode('Test');
        $address->setCountry('Test');
        return $address;
    }

    private function createProduct(string $name = 'Katze!'): Product
    {
        $product = new Product();
        $product->setName($name);
        $product->setDescription('Eine Katze, umweltschonend in Papier verpackt!');
        $product->setPrice(1337);
        $product->setStock(42);
        $product->setPicture("http://placekitten.com/g/200/300");
        $product->setIsOffer(true);
        $this->em->persist($product);
        $this->em->flush();
        return $product;
    }


    function testCreateOrder()
    {
        $address = $this->createAddress();
        $products = [$this->createProduct(name: 'Kopfhoerer'), $this->createProduct()];

        $service = new CreateOrderService($this->em);
        $order = $service->createOrder($products, $address, $address);
        $this->assertNotNull($order);
        $this->assertNotNull($order->getId());
        $this->assertEquals('invoice', $order->getInvoiceAddress()->getFirstname());
        $this->assertCount(2, $order->getOrderItems());
        $this->assertEquals('Kopfhoerer', $order->getOrderItems()[0]->getProduct()->getName());
        $this->assertEquals('Katze!', $order->getOrderItems()[1]->getProduct()->getName());
    }
}
