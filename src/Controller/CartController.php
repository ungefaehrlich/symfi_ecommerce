<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);
        $products = [];
        $total = 0;
        foreach ($cart as $cartItem) {
            $product = $productRepository->find($cartItem);
            $products[] = $product;
            $total += $product->getPrice();
        }


        return $this->render('cart/index.html.twig', [
            'products' => $products,
            'total' => $total
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
