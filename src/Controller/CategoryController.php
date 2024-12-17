<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController {
    #[Route('/categories', name: 'category.index')]
    public function index(Request $request, CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/categories/{slug}-{id}', name: 'category.show', requirements: ['slug' => '[a-z0-9\-]+', 'id' => '\d+'])]
    public function show(Request $request, string $slug, int $id, CategoryRepository $repository): Response
    {
        $category = $repository->find($id);
        if ($category->getSlug() !== $slug) {
            return $this->redirectToRoute('category.show', [
                'id' => $category->getId(),
                'slug' => $category->getSlug()
            ], 301);
        }
        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }

    #[Route('/categories/{id}/edit', name: 'category.edit', methods: ['GET', 'POST'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Catégorie modifiée avec succès');
            return $this->redirectToRoute('category.index');
        }
        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'formContent' => $form
        ]);
    }

    #[Route('/categories/create', name: 'category.create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Catégorie créée avec succès');
            return $this->redirectToRoute('category.index');
        }
        return $this->render('category/create.html.twig', [
            'formContent' => $form
        ]);
    }

    #[Route('/categories/{id}/delete', name: 'category.delete', methods: ['DELETE'])]
    public function delete(Category $category, EntityManagerInterface $em)
    {
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'Catégorie supprimée avec succès');
        return $this->redirectToRoute('category.index');
    }
}
