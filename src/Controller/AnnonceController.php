<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/annonce', name: 'app_annonce_index')]
    public function index(AnnonceRepository $annonce): Response
    {
        
        return $this->render('annonce/index.html.twig', [
            'controller_name' => 'Dealgames - Déposer une annonce',
            'annonces' => $annonce->findAll(),
            
        ]);
    }
    #[Route('/annonce/create', name: 'app_annonce_create')]
    public function create(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $annonce = new Annonce;
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $user= $this->getUser();
            
            $annonce->setUser($user);
            $entityManagerInterface->persist($annonce);
            $entityManagerInterface->flush();

            $this->addFlash('success' , 'Album Annonce enregistré !');
        }
        return $this->render('annonce/create.html.twig', [
            'formvue' => $form->createView(),
        ]);
    }

    #[Route('/annonce/edit/{id}', name: 'app_annonce_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManagerInterface, Annonce $annonce): Response
    {

        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManagerInterface->persist($annonce);
            $entityManagerInterface->flush();

            $this->addFlash('success' , 'Annonce enregistré !');
        }
        return $this->render('annonce/create.html.twig', [
            'formvue' => $form->createView(),
        ]);
    }

    #[Route('/annonce/delete/{id}', name: 'app_annonce_delete')]
    public function delete(EntityManagerInterface $entityManagerInterface, Annonce $annonce): Response
    {
        
       
            $entityManagerInterface->remove($annonce);
            $entityManagerInterface->flush();

            $this->addFlash('success' , 'Album Annonce enregistré !');
        
        return $this->redirectToRoute('app_profile'
         
        );
    }

    
    #[Route('/annonce/show/{id}', name: 'app_annonce_show')]
    public function show($id)
    {
        $annonce = $this->getDoctrine()->getRepository(Annonce::class);
        $annonce = $annonce->find($id);

       if (!$annonce) {
           throw $this->createNotFoundException(

            'Aucun annonce pour l\'id: ' . $id

           );
       }

       return $this->render(
           'annonce/show.html.twig',
           array('annonce' => $annonce)
       );
    }

   
}
