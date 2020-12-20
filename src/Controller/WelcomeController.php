<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'welcome')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('welcome/index.html.twig', [
            'products' => $productRepository->findOffers()
        ]);
    }
}
