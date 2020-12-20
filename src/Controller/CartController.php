<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/cart/add-product/{productId}', name: 'cart.add-product')]
    public function addProduct(int $productId, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $cart[] = $productId;
        $session->set('cart', $cart);
        $this->addFlash('notice', 'Product added to cart');
        return $this->redirectToRoute('product.detail', ['product' => $productId]);
    }
}
