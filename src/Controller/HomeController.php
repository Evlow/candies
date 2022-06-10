<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response

    {   $products = $doctrine->getRepository(Products::class)->findBy([], ['id' => 'DESC']); //Cherche repertoire puis entité, une fois tout récupéré class products on récupère TOUS
        return $this->render('home/index.html.twig',[
            "products"=> $products
        ]);
    }
}
