<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{
    #[Route('/', name: 'app_annonce_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnnonceRepository $annonceRepository, SluggerInterface $slugger): Response
    {
        $author = $this->getUser();
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imgfile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $annonce->setImgfile($newFilename);
            }
            $annonce->setAuthor($author);
            $annonce->setIsVisible(true);
            $annonceRepository->save($annonce, true);
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annonce_edit', methods: ['GET', 'POST'])]
    public function edit($id, Request $request, Annonce $annonce, AnnonceRepository $annonceRepository, SluggerInterface $slugger): Response
    {
        $thisAnnonce = $annonceRepository->find($id);
        if($thisAnnonce->getisVisible() == false){
            $this->addFlash('Erreur', 'Cette annonce n\'existe plus');
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        $author = $this->getUser();

        if($author == false){
            $this->addFlash('Erreur', 'vous devez avoir un compte pour ajouter une annonce');
            return $this->redirectToRoute('home');
        }
        if($author->getRoles() == 'ROLE_ADMIN' or $annonce->getAuthor()== $author){
            if ($form->isSubmitted() && $form->isValid()) {
                $imageFile = $form->get('imgfile')->getData();

                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                    try {
                        $imageFile->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
                    $annonce->setImgfile($newFilename);
                }    
                $annonceRepository->save($annonce);
                $this->addFlash('Succès', 'Votre annonce a bien été modifié');
                return $this->redirectToRoute('home,[], Response::HTTP_OTHER');

            }
            return $this->renderForm('annonce/edit.html.twig',[
                'annonce'=> $annonce, 'form'=> $form,
            ]);
        }
        $this->addFlash('Erreur', 'Vous devez avoir un comptepour ajouter/editer une annonce');
        return $this->redirectToRoute('home');
    }

    #[Route('/{id}', name: 'app_annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $annonce->getId(), $request->request->get('_token'))) {
            $annonceRepository->remove($annonce, true);
        }

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }

}
