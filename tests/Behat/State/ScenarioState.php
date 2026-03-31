<?php

namespace Tests\Behat\State;

/**
 * Класс "состояние", для хранения данных между "шагами" behat теста
  */
final class ScenarioState
{
    public ?string $responseContent = null;
    public ?array $responseJson = null;
    public ?int $statusCode = null;
    public array $headers = [];
    public ?string $token = null;
}
