<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Products;
use App\Form\ProductType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/nos-bonbons/{id}', name: 'app_product')]
    public function read($id,ManagerRegistry $doctrine): Response // On veut l'id et la methode doctrine, ca envoie une réponse
      { $products = $doctrine->getRepository(Products::class)->find($id);
        return $this->render('product/details_product.html.twig', [
            "product"=>$products
             ]);
    }


//create
#[Route('/nos-bonbons/add', name: 'add_product')]
    public function add(Request $request,ManagerRegistry $doctrine): Response
    {
        $product = new Products();
        $product->setCreatedAt(new DateTimeImmutable()); //champs auto rempli
        $formProduct = $this->createForm(ProductType::class, $product);// créer formulaire dans prodcut avec le bien
        $formProduct->handleRequest($request); //gère le traitement du form
        
        if($formProduct->isSubmitted() && $formProduct->isValid())
        {
                
        $entityManager = $doctrine->getManager(); //l'entité manager de doctrine vous permettra d'enregistrer les données en bdd

        $entityManager->persist($product);//on enregistre de nouvelles données
        $entityManager->flush();//on envoit de nouvelles données


        $this->addFlash(
            'add_success',
            'Votre bonbon à bien été ajouté !'  //envoi un message si ca fonctionne 
    
          ) ;
          return $this->redirectToRoute('app_home');
        }
        

        return $this->render('product/form_product.html.twig', [
            "formProduct" => $formProduct->createView()
        ]); 
           
    }
}


