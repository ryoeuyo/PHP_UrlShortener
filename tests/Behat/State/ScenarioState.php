<?php

namespace Tests\Behat\State;

/**
 * Класс "состояние", для хранения данных между "шагами" behat теста.
 */
final class ScenarioState
{
    public ?string $responseContent = null;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $responseJson = null;
    public ?int $statusCode = null;

    /**
     * @var string[]
     */
    public array $headers = [];
    public ?string $token = null;
}
