<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\ProductRepository;
use App\Service\CreateOrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/checkout', name: 'order.checkout')]
    public function checkout(Request $request, ProductRepository $productRepository, SessionInterface $session): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $createOrderService = new CreateOrderService($this->getDoctrine()->getManager());
            $products = $productRepository->findBy(['id' => $session->get('cart', [])]);
            $createOrderService->createOrder($products, $address, $address);
            $session->set('cart', []);
            $this->addFlash('notice', 'Order Placed !');
            return $this->redirectToRoute('welcome');
        }

        return $this->render('order/checkout.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
