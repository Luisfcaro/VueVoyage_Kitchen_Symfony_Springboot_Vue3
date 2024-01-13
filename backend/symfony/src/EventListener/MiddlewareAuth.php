<?php

namespace App\EventListener;

use App\Repository\UsersRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TokenMiddlewareListener
{
    private $jwtEncoder;
    private $usersRepository;

    public function __construct(
        JWTEncoderInterface $jwtEncoder,
        UsersRepository $usersRepository
    ) {
        $this->jwtEncoder = $jwtEncoder;
        $this->usersRepository = $usersRepository;
    }
    public function onKernelRequest(RequestEvent $event)
    {
        if ($this->isRouteProtected($event->getRequest())) {
            $request = $event->getRequest();

            if (!$request->headers->has('Authorization')) {
                return;
            }

            $authorizationHeader = $request->headers->get('Authorization');
            $token = str_replace('Bearer ', '', $authorizationHeader);

            try {
                $token = $this->jwtEncoder->decode($token);
            } catch (\Exception $e) {
                throw new AccessDeniedException('Token inválido');
            }

            $user = $this->usersRepository->findOneBy(['username' => $token['username']]);
            $isAdmin = $user->getTypeUser();

            if ($isAdmin != 'admin') {
                return new JsonResponse(['error' => 'Middleware'], 400);
            }
        }
    }

    private function isRouteProtected($request)
    {
        $route = $request->attributes->get('_route');
        $unprotectedRoutes = ['login'];

        return !in_array($route, $unprotectedRoutes);
    }

}
