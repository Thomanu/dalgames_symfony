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

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $user=$this->getUser();
        $annonce = $annonceRepository->findBy(array('user' => $user));
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'annonces' => $annonce ,
        ]);
    }
}
