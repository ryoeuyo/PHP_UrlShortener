<?php

namespace App\Presentation\Common\Controller;

use App\Presentation\Common\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class BaseController extends AbstractController
{
    protected function success(mixed $data = null, ?string $message = null, int $status = 200): JsonResponse
    {
        $response = ApiResponse::success($data, $message);

        return $this->json($response, $status, []);
    }

    /**
     * @param null|array<string, array<int, string>>|array<string, string> $errors
     */
    protected function error(string $message, ?array $errors = null, mixed $data = null, int $status = 400): JsonResponse
    {
        $response = ApiResponse::error($message, $errors, $data);

        return $this->json($response, $status);
    }

    protected function created(mixed $data = null, string $message = 'Resource created'): JsonResponse
    {
        $response = ApiResponse::created($data, $message);

        return $this->json($response, 201);
    }

    protected function notFound(string $message = 'Resource not found'): JsonResponse
    {
        $response = ApiResponse::notFound($message);

        return $this->json($response, 404);
    }

    protected function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        $response = ApiResponse::unauthorized($message);

        return $this->json($response, 401);
    }

    protected function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        $response = ApiResponse::forbidden($message);

        return $this->json($response, 403);
    }

    protected function internalError(string $message = 'Internal server error'): JsonResponse
    {
        $response = ApiResponse::error($message);

        return $this->json($response, 500);
    }

}
