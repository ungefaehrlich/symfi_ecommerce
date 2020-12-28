<?php


namespace App\Service;


use App\Entity\Address;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;

class CreateOrderService
{

    public function __construct(private ObjectManager $em)
    {
    }

    /**
     * @param Product[] $products
     * @param Address $shippingAddress
     * @param Address $invoiceAddress
     * @return Order
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createOrder(array $products, Address $shippingAddress, Address $invoiceAddress): Order
    {
        $this->em->beginTransaction();

        $this->storeAddress($shippingAddress, Address::TYPE_SHIPPING);
        $this->storeAddress($invoiceAddress, Address::TYPE_INVOICE);

        $order = new Order();
        $order->setInvoiceAddress($invoiceAddress);
        $order->setShippingAddress($shippingAddress);

        foreach ($products as $product) {
            $orderItem = $this->createOrderItemFromProduct($product);
            $order->addOrderItem($orderItem);
        }

        $this->em->persist($order);
        $this->em->flush();

        $this->em->commit();

        return $order;
    }


    private function storeAddress(Address $address, string $type): Address
    {
        $address->setType($type);
        $this->em->persist($address);
        $this->em->flush();
        return $address;
    }

    private function createOrderItemFromProduct(Product $product): OrderItem
    {
        $orderItem = new OrderItem();
        $orderItem->setPrice($product->getPrice());
        $orderItem->setProduct($product);
        $orderItem->setCount(1);
        $this->em->persist($orderItem);
        $this->em->flush();
        return $orderItem;
    }

}