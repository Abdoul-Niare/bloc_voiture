<?php

namespace App\Controller;

use App\Repository\AnnonceListByUserRepository;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function index(AnnonceRepository $annonceRepository, AnnonceListByUserRepository $annonceByUserRepo): Response
    {
        $id = $this->getUser();
        return $this->render('profile/index.html.twig', [
            

            'annonces'=> $annonceRepository->findBy(
                ['author' => $id],
            ),
            'annoncesFav'=> $annonceByUserRepo->findBy(
                ['users' => $id],
            ),
            
        ]);
    }
} 