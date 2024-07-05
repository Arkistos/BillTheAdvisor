<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/api/login', name: 'app_user', methods:['POST'])]
    public function login(
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');


        

        return new JsonResponse($user, Response::HTTP_CREATED, [], true);
    }
}
