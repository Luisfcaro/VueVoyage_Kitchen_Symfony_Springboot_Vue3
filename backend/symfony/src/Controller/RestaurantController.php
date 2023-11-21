<?php

namespace App\Controller;

use App\Entity\Restaurant;
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
    public function index(ManagerRegistry $doctrine)
    {
        try {
            $repository = $doctrine->getManager()->getRepository(Restaurant::class);
            $restaurants = $repository->findAll();
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
    public function show($id, ManagerRegistry $doctrine)
    {
        try {
            $repository = $doctrine->getManager()->getRepository(Restaurant::class);
            $restaurant = $repository->findOneBy(['id_rest' => $id]);
            if (!$restaurant instanceof Restaurant) {
                throw new \Exception('No se ha encontrado el restaurante');
            }

            // Obtener la información de las mesas del restaurante en forma de array
            // $mesasDelRestaurante = $restaurant->getTables();

            // Incluir la información de las mesas directamente en el array $data
            $data = $restaurant->toArray();
            // $data['tables'] = $mesasDelRestaurante;

            // dump(get_class($mesasDelRestaurante));
            // die();

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
    public function update(int $id, Request $request, ManagerRegistry $doctrine)
    {
        try {
            $jsonData = json_decode($request->getContent());
            $entityManager = $doctrine->getManager();
            $restaurant = $entityManager->getRepository(Restaurant::class)->find($id);
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
     * @Route("/restaurant/{id}", name="delete_restaurant", methods={"DELETE"})
     */
    public function delete(int $id, ManagerRegistry $doctrine): Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $restaurant = $entityManager->getRepository(Restaurant::class)->find($id);
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
