<?php
//src/Controller/CategoryController.php
namespace App\Controller;

use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category_index")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }
    /**
     * @param Request $request
     * @Route("/category/add", name="category_add")
     * @return Response
     */
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
        }
        return $this->render('category/formCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_one", methods={"GET"})
     * @param Category $category
     * @return Response
     */
    public function show(Category $category): Response
    {
        return $this->render('category/showByOne.html.twig', [
            'category' => $category,
        ]);
    }
}