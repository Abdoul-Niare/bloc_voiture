<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Marque;
use App\Repository\AnnonceRepository;
use App\Repository\MarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{   
    #[Route('/', name: 'home')]
    public function index(AnnonceRepository $annonceRepository, MarqueRepository $marqueRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'marques'=> $marqueRepository->findAll(),
            'annonces' => $annonceRepository ->findBy([
                'is_visible'=>true
            ]),
            // 'controller_name' => 'MainController',
        ]);
    }

    #[Route('/tab/{id}', name: 'tab', methods: ['GET'])]
    public function tab(Marque $marque, AnnonceRepository $annonceRepository, MarqueRepository $marqueRepository): Response
    {   
        // $annonces = $annonceRepo->findAll();
        return $this->render('main/tab.html.twig', [
            'marq' => $marque,
            'marque' => $marqueRepository->findAll(),
            'annonce' => $annonceRepository->findAll(),
        ]);
    }
}
