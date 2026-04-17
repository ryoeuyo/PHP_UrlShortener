<?php

namespace App\Presentation\Common\Response;

final readonly class ApiResponse
{
    /**
     * @param array<mixed| string>|null $errors
     */
    public function __construct(
        public string $status,
        public mixed $data = null,
        public ?string $message = null,
        public ?array $errors = null,
        public ?string $timestamp = null,
    ) {
    }

    public static function success(
        mixed $data = null,
        ?string $message = null,
    ): self {
        return new self(
            'success',
            $data,
            $message,
            null,
            (new \DateTimeImmutable())->format('Y-m-d H:i:s')
        );
    }

    /**
     * @param array<mixed| string>|null $errors
     */
    public static function error(string $message, ?array $errors = null, mixed $data = null): self
    {
        return new self(
            'error',
            $data,
            $message,
            $errors,
            (new \DateTimeImmutable())->format('Y-m-d H:i:s')
        );
    }

    public static function created(mixed $data = null, string $message = 'Resource created'): self
    {
        return new self(
            'success',
            $data,
            $message,
            null,
            (new \DateTimeImmutable())->format('Y-m-d H:i:s')
        );
    }

    public static function notFound(string $message = 'Resource not found'): self
    {
        return new self(
            'error',
            null,
            $message,
            null,
            (new \DateTimeImmutable())->format('Y-m-d H:i:s')
        );
    }

    public static function unauthorized(string $message = 'Unauthorized'): self
    {
        return new self(
            'error',
            null,
            $message,
            null,
            (new \DateTimeImmutable())->format('Y-m-d H:i:s')
        );
    }

    public static function forbidden(string $message = 'Forbidden'): self
    {
        return new self(
            'error',
            null,
            $message,
            null,
            (new \DateTimeImmutable())->format('Y-m-d H:i:s')
        );
    }
}
