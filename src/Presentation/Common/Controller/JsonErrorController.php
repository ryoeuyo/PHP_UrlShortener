<?php

namespace App\Presentation\Common\Controller;

use App\Application\Common\Domain\Exception\NotFoundException;
use Exception;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        // TODO: добавить обработку валидации

        if ($exception instanceof UnprocessableEntityHttpException) {
            return $this->error($exception->getMessage(), $exception->getStatusCode());
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
