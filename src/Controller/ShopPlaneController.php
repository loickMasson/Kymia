<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopPlaneController extends AbstractController
{
    #[Route('/shop/plane', name: 'shop_plane')]
    public function index(): Response
    {
        return $this->render('shop_plane/index.html.twig', [
            'controller_name' => 'ShopPlaneController',
        ]);
    }
}
