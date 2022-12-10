<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $id = $this->getUser();
        return $this->render('profile/index.html.twig', [

            // 'annoncesFilered'=> $annonceRepository->findBy(
            //     ['users' => $id],
            // ),
            'annonces'=> $annonceRepository->findBy(
                ['author' => $id],
            ),
            'controller_name' => 'ProfileController',
        ]);
    }
}