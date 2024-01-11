<?php

namespace App\Controller;

use App\Entity\Bookings;
use App\Entity\Restaurant;
use App\Entity\Tables;
use App\Entity\Turns;
use App\Entity\Users;

use App\Repository\BookingsRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TablesRepository;
use App\Repository\TurnsRepository;
use App\Repository\UsersRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;



class BookingsController extends AbstractController
{

    private $bookingsRepository;
    private $turnsRepository;
    private $restaurantRepository;
    private $tablesRepository;
    private $usersRepository;

    private $entityManager;

    public function __construct(
        BookingsRepository $bookingsRepository,
        TurnsRepository $turnsRepository,
        RestaurantRepository $restaurantRepository,
        TablesRepository $tablesRepository,
        UsersRepository $usersRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->bookingsRepository = $bookingsRepository;
        $this->turnsRepository = $turnsRepository;
        $this->restaurantRepository = $restaurantRepository;
        $this->tablesRepository = $tablesRepository;
        $this->usersRepository = $usersRepository;
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/turns", name="turns", methods={"GET"})
     */
    public function turns(): Response
    {
        try {
            $turns = $this->turnsRepository->findAll();
            $data = [];
            foreach ($turns as $turn) {
                $data[] = $turn->toArray();
            }
            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "turns" => $data
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar datos del turno.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/bookings", name="bookings", methods={"GET"})
     */
    public function index(): Response
    {
        try {
            $bookings = $this->bookingsRepository->findAll();
            $data = [];
            $order = 0;
            foreach ($bookings as $booking) {
                $data[$order] = $booking->toArray();
        
                $data[$order]['turn'] = $booking->getTurn()->toArray();
                $data[$order]['restaurant'] = $booking->getRestaurant()->toArray();
                $data[$order]['user'] = $booking->getUser()->toArray();

                $order++;
            }


            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "bookings" => $data
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar datos de la reserva.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @Route("/booking/{id}", name="booking", methods={"GET"})
     */
    public function show($id): Response
    {
        try {
            $booking = $this->bookingsRepository->find($id);

            if (!$booking instanceof Bookings) {
                throw new \Exception('No se ha encontrado la reserva');
            }

            $data = $booking->toArray();

            $data['tables'] = [];
            foreach ($booking->getTables() as $table) {
                $data['tables'][] = $table->toArray();
            }

            $data['turn'] = $booking->getTurn()->toArray();

            $data['restaurant'] = $booking->getRestaurant()->toArray();

            $data['user'] = $booking->getUser()->toArray();

            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "booking" => $data
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar los detalles de la reserva', 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * @Route("/booking", name="create_booking", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent());

            // Validar datos de entrada
            if (empty($data->date_booking) || empty($data->people) || empty($data->id_turn) || empty($data->id_rest) || empty($data->id_user)) {
                return new JsonResponse(['error' => 'Faltan datos de la reserva'], 400);
            }

            $booking = new Bookings();
            $booking->setDate(new \DateTime($data->date_booking));
            $booking->setPeople($data->people);
            $booking->setState("Pendiente");

            $turn = $this->turnsRepository->find($data->id_turn);
            if (!$turn instanceof Turns) {
                throw new \Exception('No se ha encontrado el turno');
            }
            $booking->setTurn($turn);

            $restaurant = $this->restaurantRepository->find($data->id_rest);
            if (!$restaurant instanceof Restaurant) {
                throw new \Exception('No se ha encontrado el restaurante');
            }
            $booking->setRestaurant($restaurant);

            $user = $this->usersRepository->find($data->id_user);
            if (!$user instanceof Users) {
                throw new \Exception('No se ha encontrado el usuario');
            }
            $booking->setUser($user);

            $this->entityManager->persist($booking);
            $this->entityManager->flush();


            $data_booking = $booking->toArray();

            $data_booking['turn'] = $booking->getTurn()->toArray();

            $data_booking['restaurant'] = $booking->getRestaurant()->toArray();

            $data_booking['user'] = $booking->getUser()->toArray();


            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "booking" => $data_booking
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al crear la reserva', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/booking/{id}", name="update_booking", methods={"PUT"})
     */
    public function update($id, Request $request): Response
    {
        try {
            $booking = $this->bookingsRepository->find($id);

            if (!$booking instanceof Bookings) {
                throw new \Exception('No se ha encontrado la reserva');
            }

            $data = json_decode($request->getContent());

            // Validar datos de entrada
            if (empty($data->people) || empty($data->state) || empty($data->id_turn) || empty($data->id_user)) {
                return new JsonResponse(['error' => 'Faltan datos de la reserva'], 400);
            }
            
            $booking->setPeople($data->people);
            $booking->setState($data->state);

            $turn = $this->turnsRepository->find($data->id_turn);
            if (!$turn instanceof Turns) {
                throw new \Exception('No se ha encontrado el turno');
            }
            $booking->setTurn($turn);

            $user = $this->usersRepository->find($data->id_user);
            if (!$user instanceof Users) {
                throw new \Exception('No se ha encontrado el usuario');
            }
            $booking->setUser($user);

            $this->entityManager->persist($booking);
            $this->entityManager->flush();


            $data_booking = $booking->toArray();

            $data_booking['turn'] = $booking->getTurn()->toArray();

            $data_booking['restaurant'] = $booking->getRestaurant()->toArray();

            $data_booking['user'] = $booking->getUser()->toArray();

            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "booking" => $data_booking
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al actualizar la reserva', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @Route("/booking/{id}", name="delete_booking", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        try {
            $booking = $this->bookingsRepository->find($id);

            if (!$booking instanceof Bookings) {
                throw new \Exception('No se ha encontrado la reserva');
            }

            $this->entityManager->remove($booking);
            $this->entityManager->flush();

            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "booking" => "Reserva eliminada correctamente"
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al eliminar la reserva', 'message' => $e->getMessage()], 500);
        }
    }



    /**
     * @Route("/booking/{id}/tables", name="add_table_booking", methods={"PUT"})
     */
    public function addTableToBooking($id, Request $request): Response
    {
        try {
            $booking = $this->bookingsRepository->find($id);

            if (!$booking instanceof Bookings) {
                throw new \Exception('No se ha encontrado la reserva');
            }

            $data = json_decode($request->getContent());

            // Validar datos de entrada
            if (empty($data->id_table)) {
                return new JsonResponse(['error' => 'Faltan datos de la reserva'], 400);
            }

            $table = $this->tablesRepository->find($data->id_table);
            if (!$table instanceof Tables) {
                throw new \Exception('No se ha encontrado la mesa');
            }

            $booking->addTable($table);

            $this->entityManager->persist($booking);
            $this->entityManager->flush();


            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "table" => $table->toArray()
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al añadir la mesa a la reserva', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @Route("/booking/{id}/tables", name="delete_table_booking", methods={"DELETE", "POST"})
     */
    public function deleteTableToBooking($id, Request $request): Response
    {
        try {
            $booking = $this->bookingsRepository->find($id);

            if (!$booking instanceof Bookings) {
                throw new \Exception('No se ha encontrado la reserva');
            }

            $data = json_decode($request->getContent());

            // Validar datos de entrada
            if (empty($data->id_table)) {
                return new JsonResponse(['error' => 'Faltan datos de la reserva'], 400);
            }

            $table = $this->tablesRepository->find($data->id_table);
            if (!$table instanceof Tables) {
                throw new \Exception('No se ha encontrado la mesa');
            }

            $booking->removeTable($table);

            $this->entityManager->persist($booking);
            $this->entityManager->flush();

            return new JsonResponse([
                "status" => 200,
                "message" => "success",
                "table" => $table->toArray()
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al eliminar la mesa de la reserva', 'message' => $e->getMessage()], 500);
        }
    }
}
