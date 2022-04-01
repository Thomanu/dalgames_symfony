<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Form\AnnonceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog/{id}', name: 'app_catalog')]
    public function index(Categorie $categorie, AnnonceRepository $annonce): Response
    {
        $annonce->findBy(array('categorie' => $categorie-> getId()));
        return $this->render('catalog/index.html.twig', [
            'controller_name' => 'Dealgames - Déposer une annonce',
            'annonces' => $annonce->findBy(array('categorie' => $categorie-> getId())),
        ]);
    }
}
