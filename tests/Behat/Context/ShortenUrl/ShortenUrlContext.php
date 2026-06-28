<?php

namespace Tests\Behat\Context\ShortenUrl;

use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpKernel\KernelInterface;
use Tests\Behat\Context\BaseContext;
use Tests\Behat\State\ScenarioState;

final class ShortenUrlContext extends BaseContext
{
    private const CONTENT_TYPE = 'application/json';
    private const HTTP_ACCEPT = 'application/json';

    private KernelBrowser $client;

    public function __construct(
        private readonly ScenarioState $state,
        private readonly Connection $connection,
        KernelInterface $kernel,
    ) {
        $this->client = new KernelBrowser($kernel);
    }

    #[Given('я создал короткую ссылку для :url')]
    public function iCreatedShortenUrl(string $url): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/shorten',
            server: [
                'CONTENT_TYPE' => self::CONTENT_TYPE,
                'HTTP_ACCEPT' => self::HTTP_ACCEPT,
                ...$this->state->headers,
            ],
            content: (string)json_encode(['url' => $url, 'ttlSeconds' => 3600]),
        );

        $response = $this->client->getResponse();

        if ($response->getStatusCode() !== 201) {
            $this->fail(sprintf(
                'Не удалось создать короткую ссылку. Код: %d, ответ: %s',
                $response->getStatusCode(),
                $response->getContent(),
            ));
        }

        $data = json_decode((string) $response->getContent(), true);
        $alias = is_array($data) ? ($data['alias'] ?? $data['data']['alias'] ?? null) : null;

        if (!is_string($alias)) {
            $this->fail('Alias отсутствует в ответе создания короткой ссылки');
        }

        $this->state->lastAlias = $alias;
    }

    #[When('я перехожу по короткой ссылке')]
    public function iFollowShortLink(): void
    {
        $alias = $this->requireAlias();

        $this->client->followRedirects(false);
        $this->client->request(
            method: 'GET',
            uri: '/r/' . $alias,
            server: [
                'HTTP_USER_AGENT' => 'BehatTestAgent/1.0',
                'REMOTE_ADDR' => '203.0.113.10',
            ],
        );

        $response = $this->client->getResponse();

        $this->state->statusCode = $response->getStatusCode();
        $this->state->responseJson = null;
    }

    #[When('я запрашиваю список кликов по короткой ссылке')]
    public function iRequestClickList(): void
    {
        $alias = $this->requireAlias();
        $shortenId = $this->resolveShortenId($alias);

        $this->client->followRedirects(false);
        $this->client->request(
            method: 'GET',
            uri: sprintf('/api/shorten/%d/clicks/', $shortenId),
            server: [
                'HTTP_ACCEPT' => self::HTTP_ACCEPT,
                ...$this->state->headers,
            ],
        );

        $response = $this->client->getResponse();

        $this->state->statusCode = $response->getStatusCode();
        $this->state->responseJson = json_decode((string) $response->getContent(), true);
    }

    #[Then('количество кликов по короткой ссылке должно быть :count')]
    public function assertClickCount(int $count): void
    {
        $alias = $this->requireAlias();

        $actual = (int) $this->connection->fetchOne(
            'SELECT COUNT(*) FROM shorten_url_clicks c
             JOIN shorten_urls s ON c.shorten_url_id = s.id
             WHERE s.alias = :alias',
            ['alias' => $alias],
        );

        if ($actual !== $count) {
            $this->fail(sprintf(
                'Ожидалось кликов: %d, найдено: %d (alias "%s")',
                $count,
                $actual,
                $alias,
            ));
        }
    }

    private function resolveShortenId(string $alias): int
    {
        $id = $this->connection->fetchOne(
            'SELECT id FROM shorten_urls WHERE alias = :alias',
            ['alias' => $alias],
        );

        if ($id === false) {
            $this->fail(sprintf('Короткая ссылка с alias "%s" не найдена', $alias));
        }

        return (int) $id;
    }

    private function requireAlias(): string
    {
        if (!is_string($this->state->lastAlias)) {
            $this->fail('Сначала нужно создать короткую ссылку');
        }

        return $this->state->lastAlias;
    }
}
