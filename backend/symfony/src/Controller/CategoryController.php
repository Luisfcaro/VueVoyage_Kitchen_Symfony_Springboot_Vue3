<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="categories", methods={"GET"})
     */
    public function index(ManagerRegistry $doctrine)
    {
        try {
            $repository = $doctrine->getManager()->getRepository(Category::class);
            $categories = $repository->findAll();
            $data = [];
            foreach ($categories as $category) {
                $data[] = $category->toArray();
            }
            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "categories" => $data
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar datos de las categorias.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/category/{id}", name="category", methods={"GET"})
     */
    public function show($id, ManagerRegistry $doctrine): Response
    {
        try {
            $repository = $doctrine->getManager()->getRepository(Category::class);
            $category = $repository->findOneBy(['id_cat' => $id]);
            if (!$category instanceof Category) {
                throw new \Exception('No se ha encontrado la categoria');
            }
            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "category" => $category->toArray()
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar los detalles de la categoria', 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * @Route("/category", name="create_category", methods={"POST"})
     */
    public function create(Request $request, ManagerRegistry $doctrine)
    {
        try {
            $jsonData = json_decode($request->getContent());
            $entityManager = $doctrine->getManager();
            $category = new Category();
            $category->setNameCat($jsonData->name_cat);
            $category->setImgCat($jsonData->img_cat);
            $entityManager->persist($category);
            $entityManager->flush();
            return new JsonResponse([
                'status' => 201,
                'message' => 'Categoria creada correctamente',
                'category' => $category->toArray(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al crear la categoria', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/category/{id}", name="update_category", methods={"PUT"})
     */
    public function update(int $id, Request $request, ManagerRegistry $doctrine)
    {
        try {
            $jsonData = json_decode($request->getContent());
            $entityManager = $doctrine->getManager();
            $category = $entityManager->getRepository(Category::class)->findOneBy(['id_cat' => $id]);
            if ($category === null) {
                return new JsonResponse(['error' => 'Categoria no encontrada.'], 404);
            }
            $category->setNameCat($jsonData->name_cat);
            $category->setImgCat($jsonData->img_cat);
            $entityManager->flush();
            return new JsonResponse([
                'status' => 200,
                'message' => 'Categoría actualizada correctamente',
                'category' => $category->toArray()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al actualizar los datos de la categoria'], 500);
        }
    }

    /**
     * @Route("/category/{id}", name="delete_category", methods={"DELETE"})
     */
    public function delete(int $id, ManagerRegistry $doctrine): Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $category = $entityManager->getRepository(Category::class)->findOneBy(['id_cat' => $id]);
            if (!$category) {
                return new JsonResponse(['error' => 'Categoria no encontrada.'], 404);
            }
            $entityManager->remove($category);
            $entityManager->flush();
            return new JsonResponse([
                "status" => 200,
                "message" => "Categoria eliminada con exito"
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse([
                "message" => "Error al eliminar la categoria."
            ], 500);
        }
    }
}
