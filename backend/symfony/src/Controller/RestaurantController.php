<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Restaurant;
use App\Entity\Tables;
use App\Repository\CategoryRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TablesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurants", name="restaurants", methods={"GET"})
     */
    public function index(RestaurantRepository $restaurantRepository)
    {
        try {
            $restaurants = $restaurantRepository->findAll();
            $data = [];
            foreach ($restaurants as $restaurant) {
                $data[] = $restaurant->toArray();
            }
            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "restaurants" => $data
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar datos del restaurante.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/restaurant/{id}", name="restaurant", methods={"GET"})
     */
    public function show($id, RestaurantRepository $restaurantRepository, TablesRepository $tablesRepository)
    {
        try {
            $restaurant = $restaurantRepository->find($id);

            if (!$restaurant instanceof Restaurant) {
                throw new \Exception('No se ha encontrado el restaurante');
            }

            $tablesRestaurant = $tablesRepository->findBy(['id_rest' => $restaurant->getIdRest()]);

            $data = $restaurant->toArray();
            $data['tables'] = [];
            foreach ($tablesRestaurant as $table) {
                $data['tables'][] = $table->toArray();
            }

            $data['categories'] = $restaurantRepository->findCategoriesOfIdRestaurant($id);


            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "restaurant" => $data
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar los detalles del restaurante', 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * @Route("/restaurant", name="create_restaurant", methods={"POST"})
     */
    public function create(Request $request, ManagerRegistry $doctrine)
    {
        try {
            $jsonData = json_decode($request->getContent());
            $entityManager = $doctrine->getManager();
            $restaurant = new Restaurant();
            $restaurant->setNameRest($jsonData->name_rest);
            $restaurant->setImgRest($jsonData->img_rest);
            $restaurant->setLocationRest($jsonData->location_rest);
            $entityManager->persist($restaurant);
            $entityManager->flush();
            return new JsonResponse([
                "status" => 201,
                "message" => "El restaurante fue creado correctamente.",
                "restaurant" => $restaurant->toArray()
            ], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al crear el restaurante', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/restaurant/{id}", name="update_restaurant", methods={"PUT"})
     */
    public function update(int $id, Request $request, ManagerRegistry $doctrine, RestaurantRepository $restaurantRepository)
    {
        try {
            $jsonData = json_decode($request->getContent());
            $entityManager = $doctrine->getManager();
            $restaurant = $restaurantRepository->find($id);
            if ($restaurant === null) {
                return new JsonResponse(['error' => 'Restaurante no encontrado.'], 404);
            }

            $restaurant->setNameRest($jsonData->name_rest);
            $restaurant->setImgRest($jsonData->img_rest);
            $restaurant->setLocationRest($jsonData->location_rest);

            $entityManager->flush();
            return new JsonResponse([
                "status" => 200,
                "message" => "Se actualizaron los datos del restaurante.",
                "restaurant" => $restaurant->toArray()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al actualizar los datos del restaurante'], 500);
        }
    }

    /**
     * @Route("/restaurant/{id}/addCategory", name="add_category_restaurant", methods={"PUT"})
     */
    public function addCategoryToRestaurant(int $id, Request $request, ManagerRegistry $doctrine, RestaurantRepository $restaurantRepository, CategoryRepository $categoryRepository)
    {
        try {
            $jsonData = json_decode($request->getContent());
            $entityManager = $doctrine->getManager();
            $restaurant = $restaurantRepository->find($id);
            if ($restaurant === null) {
                return new JsonResponse(
                    ['error' => 'Restaurante no encontrado.'],
                    404
                );
            }
            $category = $categoryRepository->find($jsonData->category);
            if ($category) {
                $restaurant->addCategory($category, $jsonData->description);
                $entityManager->flush();
                $restaurantRepository->insertDescInRel($id, $jsonData->category, $jsonData->description);
                return new JsonResponse([
                    "status" => 200,
                    "message" => "Se agrego la categoria al restaurante.",
                    "restaurant" => $restaurant->toArray()
                ]);
            } else {
                return new JsonResponse(['error' => 'Categoria no encontrada.'], 404);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al agregar la categoria al restaurante', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/restaurant/{id_rest}/removeCategory/{id_cat}", name="remove_category_restaurant", methods={"DELETE"})
     */
    public function removeCategoryFromRestaurant($id_rest, $id_cat, RestaurantRepository $restaurantRepository): Response
    {
        try {
            $restaurantRepository->deleteRel($id_rest, $id_cat);
            return new JsonResponse([
                "status" => 200,
                "message" => "Se elimino la categoria al restaurante."
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al eliminar la categoria al restaurante', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/restaurant/{id}", name="delete_restaurant", methods={"DELETE"})
     */
    public function delete(int $id, ManagerRegistry $doctrine, RestaurantRepository $restaurantRepository): Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $restaurant = $restaurantRepository->find($id);
            if (!$restaurant) {
                return new JsonResponse(['error' => 'Restaurante no encontrado.'], 404);
            }
            $entityManager->remove($restaurant);
            $entityManager->flush();
            return new JsonResponse([
                "status" => 200,
                "message" => "El restaurante ha sido eliminado."
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al eliminar el restaurante.'], 500);
        }
    }
}
