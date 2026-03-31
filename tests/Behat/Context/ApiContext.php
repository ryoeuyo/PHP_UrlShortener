<?php

namespace Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Step\Then;
use Behat\Step\When;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use Tests\Behat\State\ScenarioState;

final class ApiContext extends WebTestCase implements Context
{
    private const CONTENT_TYPE = 'application/json';
    private const HTTP_ACCEPT = 'application/json';

    private KernelBrowser $client;

    public function __construct(private readonly ScenarioState $state)
    {
        $this->client = self::createClient();
    }

    #[When('я отправляю :method запрос на :uri с JSON:')]
    public function sendJsonRequest(string $method, string $uri, string $json): void
    {
        $this->client->request(
            method: $method,
            uri: $uri,
            server: [
                'CONTENT_TYPE' => self::CONTENT_TYPE,
                'HTTP_ACCEPT' => self::HTTP_ACCEPT,
                ...$this->state->headers,
            ],
            content: $json,
        );

        $response = $this->client->getResponse();

        $this->state->statusCode = $response->getStatusCode();
        $this->state->headers = $response->getHeaders();
        $this->state->responseJson = json_decode($response->getContent(), true);
    }

    #[Then('код ответа должен быть :statusCode')]
    public function assertStatusCode(int $statusCode): void
    {
        if ($this->state->statusCode !== $statusCode) {
            $this->fail(sprintf(
                'Ожидался код %d, получен %d. Ответ: %s',
                $statusCode,
                $this->state->statusCode,
                $this->state->responseContent
            ));
        }
    }

    #[Then('ответ должен содержать поле :field со значением :value')]
    public function assertResponseField(string $field, string $expected): void
    {
        $actual = $this->state->responseJson[$field] ?? null;

        if ((string) $actual !== $expected) {
            $this->fail(sprintf(
                'Поле "%s" ожидалось со значением "%s", получено "%s"',
                $field,
                $expected,
                $actual
            ));
        }
    }

    #[Then('ответ должен содержать поле :field')]
    public function assertResponseHasField(string $field): void
    {
        $actual = $this->state->responseJson[$field] ?? null;

        if ($actual === null) {
            $this->fail(sprintf(
                'Поле "%s" отсутствует в ответе',
                $field
            ));
        }
    }

    #[Then('ответ должен содержать поле :field с валидным UUIDv4')]
    public function assertResponseFieldIsValidUuidV4(string $field): void
    {
        $actual = $this->state->responseJson[$field] ?? null;

        if (Uuid::isValid($actual) !== false) {
            $this->fail(sprintf(
                'Поле "%s" не содержит валидный UUIDv4. Получено: %s',
                $field,
                $actual
            ));
        }
    }
}
