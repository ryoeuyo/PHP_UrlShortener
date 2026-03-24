<?php

namespace App\Tests\E2e\Calculator;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CalculateControllerTest extends WebTestCase
{
    public function testCalculate(): void
    {
        $client = self::createClient();

        $crawler = $client->request(
            method: 'POST',
            uri: '/calculator/calculate',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'left' => 5,
                'right' => 5,
            ])
        );

        $this->assertResponseIsSuccessful();

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(10, $responseData['result'] ?? null);
    }
}
