<?php

namespace App\Controller;

use App\Entity\Tables;
use App\Repository\TablesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TablesController extends AbstractController
{
    /**
     * @Route("/tables", name="tables", methods={"GET"})
     */
    public function index(TablesRepository $tablesRepository): Response
    {
        try {
            $tables = $tablesRepository->findAll();

            $data = [];
            foreach ($tables as $table) {
                $data[] = $table->toArray();
            }

            return new JsonResponse($data, 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar datos de la tabla.'], 500);
        }
    }

    /**
     * @Route("/table/{id}", name="tables_show", methods={"GET"})
     */
    public function show(int $id, TablesRepository $tablesRepository): Response
    {
        try {
            $table = $tablesRepository->find($id);

            if (!$table instanceof Tables) {
                throw new \Exception('No se ha encontrado una mesa con el id: ' . $id);
            }
            $data = $table->toArray();

            return new JsonResponse($data, 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al obtener los detalles de la mesa'], 404);
        }
    }

    /**
     * @Route("/table", name="create_table", methods={"POST"})
     */
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $jsonData = json_decode($request->getContent());
        try {
            $entityManager = $doctrine->getManager();
            $table = new Tables();
            $table->setNumTable($jsonData->number_table);
            $table->setIdRest($jsonData->id_rest);
            $table->setCapacityTable($jsonData->capacity_table);
            $table->setStatusTable($jsonData->status_table);
            $entityManager->persist($table);
            $entityManager->flush();
            return new JsonResponse([
                "message" => "Mesa creada correctamente.",
                "code" => 201,
                "table" => $table->toArray()
            ], 201);
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => 'Error al crear la mesa'], 409);
        }
    }

    /**
     * @Route("/table/{id}", name="update_table", methods={"PUT"})
     */
    public function update(Request $request, ManagerRegistry $doctrine, TablesRepository $tablesRepository, int $id): Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $table = $tablesRepository->find($id);

            if (!$table) {
                return new JsonResponse(['error' => 'Mesa no encontrada.'], 404);
            }

            $jsonData = json_decode($request->getContent());

            $table->setNumTable($jsonData->number_table);
            $table->setCapacityTable($jsonData->capacity_table);
            $table->setStatusTable($jsonData->status_table);

            $entityManager->flush();

            return new JsonResponse([
                'message' => 'Mesa actualizada correctamente.',
                'code' => 200,
                "table" => $table->toArray()
            ], 200);
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => 'Error al actualizar la mesa.'], 500);
        }
    }

    /**
     * @Route("/table/{id}", name="delete_table", methods={"DELETE"})
     */
    public function delete(ManagerRegistry $doctrine, TablesRepository $tablesRepository, $id): Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $table = $tablesRepository->find($id);

            if (!$table) {
                return new JsonResponse(['error' => 'Mesa no encontrada.'], 404);
            }

            $entityManager->remove($table);
            $entityManager->flush();

            return new JsonResponse([
                'message' => 'Mesa eliminada correctamente.',
                'code' => 200
            ], 200);
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => 'Error al eliminar la mesa.'], 500);
        }
    }
}
