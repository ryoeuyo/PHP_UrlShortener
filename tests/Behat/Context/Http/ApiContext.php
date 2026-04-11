<?php

namespace Tests\Behat\Context\Http;

use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Uid\Uuid;
use Tests\Behat\Context\BaseContext;
use Tests\Behat\State\ScenarioState;

class ApiContext extends BaseContext
{
    private const CONTENT_TYPE = 'application/json';
    private const HTTP_ACCEPT = 'application/json';

    private KernelBrowser $client;

    public function __construct(
        private readonly ScenarioState $state,
        KernelInterface $kernel,
    ) {
        $this->client = new KernelBrowser($kernel);
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
        $this->state->headers = $response->headers->all();
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
        $actual = $this->getResponseJsonField($field);

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
        $actual = $this->getResponseJsonField($field);

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
        $actual = $this->getResponseJsonField($field);

        if (Uuid::isValid($actual) === false) {
            $this->fail(sprintf(
                'Поле "%s" не содержит валидный UUIDv4. Получено: %s',
                $field,
                $actual
            ));
        }
    }

    #[Given('я авторизован как пользователь с email :email и паролем :password')]
    public function iAmAuthorized(string $email, string $password): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/auth/login',
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ],
            content: json_encode([
                'email' => $email,
                'password' => $password,
            ]),
        );

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        if (!isset($data['data']['accessToken'])) {
            $this->fail('JWT токен не получен');
        }

        $this->state->headers['HTTP_AUTHORIZATION'] = 'Bearer ' . $data['data']['accessToken'];
    }

    private function getResponseJsonField(string $field): ?string
    {
        return $this->state->responseJson[$field]
            ?? $this->state->responseJson['data'][$field]
            ?? null;
    }
}
