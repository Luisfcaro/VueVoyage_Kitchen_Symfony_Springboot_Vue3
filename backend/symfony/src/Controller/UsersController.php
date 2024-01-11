<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;



class UsersController extends AbstractController
{
    private $jwtEncoder;
    private $usersRepository;
    private $passwordHasher;
    private $entityManager;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        JWTEncoderInterface $jwtEncoder,
        UsersRepository $usersRepository,
        EntityManagerInterface $entityManager,
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->jwtEncoder = $jwtEncoder;
        $this->usersRepository = $usersRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent());

            // Validar datos de entrada
            if (empty($data->username) || empty($data->password)) {
                return new JsonResponse(['error' => 'Faltan datos de usuario y/o contraseña'], 400);
            }

            // Obtenemos los datos del ususario
            $user = $this->usersRepository->findOneBy(['username' => $data->username]);

            if (!$user) {
                return new JsonResponse(['error' => 'Usuario no encontrado'], 404);
            }

            // Comprobamos que la contraseña sea correcta
            if (!$this->passwordHasher->isPasswordValid($user, $data->password)) {
                return new JsonResponse(['error' => 'Contraseña incorrecta'], 401);
            }

            // Generamos el token
            $bearer = $this->jwtEncoder->encode([
                'username' => $user->getUsername(),
                'rt' => $user->getRt(),
                'exp' => time() + 3600 // 1 hora de duración del token
            ]);


            return new JsonResponse([
                'status' => 200,
                'message' => 'Autenticación exitosa',
                'Bearer' => $bearer
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al procesar la solicitud', 'message' => $e->getMessage()], 500);
        }
    }



    /**
     * @Route("/logout", name="logout", methods={"POST"})
     */
    public function logout(Request $request): Response
    {
        try {
            $bearer = $request->headers->get('Authorization');
            $bearer = str_replace('Bearer ', '', $bearer);
            $token = $this->jwtEncoder->decode($bearer);

            $user = $this->usersRepository->findOneBy(['username' => $token['username']]);

            if (!$user) {
                return new JsonResponse(['error' => 'Usuario no encontrado'], 404);
            }

            if ($user->getRt() != $token['rt']) {
                return new JsonResponse(['error' => 'Token no válido'], 401);
            }

            // Generar un nuevo valor aleatorio para rt
            $newRt = bin2hex(random_bytes(10));
            $user->setRt($newRt);

            // Guardar el cambio en la base de datos
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse([
                'status' => 200,
                'message' => 'Sesión cerrada',
                'Rt' => $newRt
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al procesar la solicitud', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @Route("/isAdmin", name="isAdmin", methods={"POST"})
     */
    public function isAdmin(Request $request): Response
    {
        try {
            $bearer = $request->headers->get('Authorization');
            $bearer = str_replace('Bearer ', '', $bearer);
            $token = $this->jwtEncoder->decode($bearer);

            $user = $this->usersRepository->findOneBy(['username' => $token['username']]);
            $isAdmin = $user->getTypeUser();

            return new JsonResponse([
                'status' => 200,
                'message' => 'Permisos del usuario comprobados',
                'isAdmin' => $isAdmin,
                'rt' => $user->getRt()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al procesar la solicitud', 'message' => $e->getMessage()], 500);
        }
    }





    /**
     * @Route("/users", name="get_users", methods={"GET"})
     */
    public function index(): Response
    {
        try {
            $users = $this->usersRepository->findAll();

            $data = [];
            foreach ($users as $user) {
                $data[] = $user->toArray();
            }

            return new JsonResponse([
                'status' => 200,
                'message' => 'success',
                'users' => $data
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar los usuarios', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @Route("/user/{id}", name="get_user", methods={"GET"})
     */
    public function show($id): Response
    {
        try {
            $user = $this->usersRepository->find($id);

            if (!$user instanceof Users) {
                throw new \Exception('No se ha encontrado el usuario');
            }

            $data = $user->toArray();

            // dd($user->getBookings()->toArray());

            $data['bookings'] = [];
            foreach ($user->getBookings() as $booking) {
                $data['bookings'][] = $booking->toArray();
            }

            return new JsonResponse([
                'status' => 200,
                'message' => 'success',
                'user' => $data
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al recuperar el usuario', 'message' => $e->getMessage()], 404);
        }
    }


    /**
     * @Route("/user", name="create_user", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent());

            // Validar datos de entrada
            if (empty($data->username) || empty($data->password) || empty($data->typeUser) || empty($data->email)) {
                return new JsonResponse(['error' => 'Faltan datos de usuario y/o contraseña'], 400);
            }

            // Comprobar si el usuario ya existe
            $user = $this->usersRepository->findOneBy(['username' => $data->username]);

            if ($user) {
                return new JsonResponse(['error' => 'El usuario ya existe'], 400);
            }

            // Crear el usuario
            $user = new Users();
            $user->setUsername($data->username);
            $user->setPassword($this->passwordHasher->hashPassword($user, $data->password));
            $user->setEmail($data->email);
            $user->setTypeUser($data->typeUser);
            $user->setIsActive(true);
            $user->setPhoto($data->photo);
            $user->setRt(bin2hex(random_bytes(10)));

            // Guardar el usuario en la base de datos
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse([
                'status' => 200,
                'message' => 'Usuario creado',
                'user' => $user->toArray()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al crear el usuario', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @Route("/user/{id}", name="update_user", methods={"PUT"})
     */
    public function update($id, Request $request): Response
    {
        try {
            $data = json_decode($request->getContent());

            // Validar datos de entrada
            if (empty($data->username) || empty($data->typeUser) || empty($data->password) || empty($data->email)) {
                return new JsonResponse(['error' => 'Faltan datos de usuario y/o contraseña'], 400);
            }

            // Comprobar si el usuario ya existe
            $user = $this->usersRepository->findOneBy(['username' => $data->username]);

            if ($user && $user->getId() != $id) {
                return new JsonResponse(['error' => 'El usuario ya existe'], 400);
            }

            // Buscar el usuario
            $user = $this->usersRepository->find($id);

            if (!$user instanceof Users) {
                throw new \Exception('No se ha encontrado el usuario');
            }

            // Actualizar el usuario
            $user->setUsername($data->username);
            $user->setPassword($this->passwordHasher->hashPassword($user, $data->password));
            $user->setEmail($data->email);
            $user->setPhoto($data->photo);
            $user->setTypeUser($data->typeUser);

            // Guardar el usuario en la base de datos
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse([
                'status' => 200,
                'message' => 'Usuario actualizado',
                'user' => $user->toArray()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al actualizar el usuario', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @Route("/user/{id}", name="delete_user", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        try {
            // Buscar el usuario
            $user = $this->usersRepository->find($id);

            if (!$user instanceof Users) {
                throw new \Exception('No se ha encontrado el usuario');
            }

            // Eliminar el usuario
            $this->entityManager->remove($user);
            $this->entityManager->flush();

            return new JsonResponse([
                'status' => 200,
                'message' => 'Usuario eliminado'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al eliminar el usuario', 'message' => $e->getMessage()], 500);
        }
    }
}
