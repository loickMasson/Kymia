<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Form\CategorieType;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/categorie')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'admin_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('admin/admin_categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request,SluggerInterface $slugger, ImageService $imageService): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Je recupère le fichier directement dans le formulaire

            $file = $form->get('image')->getData();

            // Je transforme de nom du fichier

            $originalName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            $safeName = $slugger->slug($originalName);
            $uniqFIleName = $safeName . '-' . uniqid() . '.' . $file->guessExtension();

            // Je met le fichier dans le dossier upload
            $file->move

            if($file)
            {
                $imageService->sauvegarderImage($categorie,$file);

            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('admin_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('admin/admin_categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie,ImageService $imageService): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        $ancienneImage = $categorie->getImage;

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('image_upload')->getData();

            if($file)
            {
                $imageService->sauvegarderImage($categorie,$file);
            }

            if($ancienneImage)
            {
                $imageService->supprimerImage($ancienneImage);
            }

            $this->getDoctrine()->getManager()->flush(); 


            return $this->redirectToRoute('admin_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, ImageServices $imageService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) { 

            // Supprimer l'image qu'il y'a dans la categorie
            $imageService->supprimerImage($categorie->getImage);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
