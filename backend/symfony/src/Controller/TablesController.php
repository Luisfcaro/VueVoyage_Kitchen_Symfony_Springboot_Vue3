<?php

namespace App\Controller;

use App\Entity\Tables;
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
    public function index(ManagerRegistry $doctrine): Response
    {
        try {
            $repository = $doctrine->getManager()->getRepository(Tables::class);
            $tables = $repository->findAll();

            $data = [];
            foreach ($tables as $table) {
                $data[] = [
                    'id_table' => $table->getIdTable(),
                    'number_table' => $table->getNumTable(),
                    'id_rest' => $table->getIdRest(),
                    'capacity_table' => $table->getCapacityTable(),
                    'status_table' => $table->getStatusTable()
                ];
            }

            return new JsonResponse($data, 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar datos de la tabla.'], 500);
        }
    }

    /**
     * @Route("/table/{id}", name="tables_show", methods={"GET"})
     */
    public function show(int $id, ManagerRegistry $doctrine): Response
    {
        try {
            $repository = $doctrine->getManager()->getRepository(Tables::class);
            $table = $repository->findOneBy([
                'id_table' => $id
            ]);
            if (!$table instanceof Tables) {
                throw new \Exception('No se ha encontrado una mesa con el id: ' . $id);
            }
            $data = [
                'id_table' => $table->getIdTable(),
                'number_table' => $table->getNumTable(),
                'id_rest' => $table->getIdRest(),
                'capacity_table' => $table->getCapacityTable(),
                'status_table' => $table->getStatusTable()
            ];
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
            $table->setCapacityTable($jsonData->capacity_table);
            $table->setStatusTable($jsonData->status_table);
            $entityManager->persist($table);
            $entityManager->flush();
            return new JsonResponse([
                "message" => "Mesa creada correctamente.",
                "code" => 201,
                "table" => [
                    'id_table' => $table->getIdTable(),
                    'number_table' => $table->getNumTable(),
                    'id_rest' => $table->getIdRest(),
                    'capacity_table' => $table->getCapacityTable(),
                    'status_table' => $table->getStatusTable()
                ]
            ], 201);
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => 'Error al crear la mesa'], 409);
        }
    }

    /**
     * @Route("/table/{id}", name="update_table", methods={"PUT"})
     */
    public function update(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $repository = $entityManager->getRepository(Tables::class);
            $table = $repository->find($id);

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
                "table" => [
                    'id_table' => $table->getIdTable(),
                    'number_table' => $table->getNumTable(),
                    'id_rest' => $table->getIdRest(),
                    'capacity_table' => $table->getCapacityTable(),
                    'status_table' => $table->getStatusTable()
                ]
            ], 200);
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => 'Error al actualizar la mesa.'], 500);
        }
    }

    /**
     * @Route("/table/{id}", name="delete_table", methods={"DELETE"})
     */
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $repository = $entityManager->getRepository(Tables::class);
            $table = $repository->find($id);

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
