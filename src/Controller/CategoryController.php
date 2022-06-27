<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Trait\RoleTrait;
use App\Form\EditCategoryFormType;

#[Route('/category', name: 'category-')]
class CategoryController extends AbstractController
{

    use RoleTrait;

    #[Route('/', name: 'main')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll()
        ]);
    }

    #[Route('/{id<\d+>}', name: 'byId')]
    public function categoryById(Category $category): Response
    {
        return $this->render('category/category.html.twig', [
            'category' => $category,
            'posts' => $category->getTopics(),
        ]);
    }

    #[Route('/{slug}', name: 'bySlug')]
    public function categoryBySlug(Category $category): Response
    {
        return $this->render('category/category.html.twig', [
            'category' => $category,
            'posts' => $category->getTopics(),
        ]);
    }

    #[Route('edit/{slug}', name: 'edit-bySlug')]
    public function editCategoryBySlug(Category $category, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($response = $this->checkRole('ROLE_ADMINISTRATOR')) {
            return $response;
        }

        $form = $this->createForm(EditCategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($this->getUser() && $form->isSubmitted() && $form->isValid()) {
            /** @var User $author */
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category-main');
        }

        return $this->render('category/category.edit.html.twig', [
            'category' => $category,
            'editCategoryForm' => $form->createView(),
        ]);
    }
}
