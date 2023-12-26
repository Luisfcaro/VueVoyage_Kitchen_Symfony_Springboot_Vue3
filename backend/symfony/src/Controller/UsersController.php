<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;



class UsersController extends AbstractController
{
    private $jwtEncoder;
    private $usersRepository;
    private $passwordHasher;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        JWTEncoderInterface $jwtEncoder,
        UsersRepository $usersRepository
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->jwtEncoder = $jwtEncoder;
        $this->usersRepository = $usersRepository;
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


            return new JsonResponse([
                'status' => 200,
                'message' => 'Sesión cerrada',
                'Bearer' => $bearer
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
        
}
