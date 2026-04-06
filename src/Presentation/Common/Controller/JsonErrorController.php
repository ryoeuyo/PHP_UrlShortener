<?php

namespace App\Presentation\Common\Controller;

use App\Application\Common\Domain\Exception\NotFoundException;
use App\Application\Common\Domain\Exception\ValidationException;
use Exception;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

final class JsonErrorController extends BaseController
{
    public function __invoke(Throwable $exception): JsonResponse
    {
        $message = $exception->getMessage();

        if ($exception instanceof NotFoundException) {
            return $this->notFound($message);
        }

        if ($exception instanceof ValidationException) {
            $violations = $exception->getViolations();

            return $this->error(
                message: $exception->getMessage(),
                errors: $violations,
                status: Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        if ($exception instanceof UnprocessableEntityHttpException) {
            return $this->error(
                message: $exception->getMessage(),
                status: $exception->getStatusCode(),
            );
        }

        if (get_class($exception) === "ValueError") {
            return $this->internalError();
        }

        if ($exception instanceof RuntimeException) {
            return $this->internalError($message);
        }

        if ($exception instanceof Exception) {
            return $this->error($message);
        }

        return $this->internalError($message);

    }
}
