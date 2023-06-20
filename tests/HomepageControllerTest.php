<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    public function testTheHomepageSaysHello(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $returnedJson = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $returnedJson);
        $this->assertSame('Hello World!', $returnedJson['message']);
    }

    /**
     * @dataProvider provideHelloPageSuffixes
     */
    public function testTheHelloPageSaysHello(string $urlSuffix, string $expectedHello)
    {
        $client = static::createClient();
        $client->request('GET', '/hello' . $urlSuffix);

        $this->assertResponseIsSuccessful();
        $returnedJson = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $returnedJson);
        $this->assertSame($expectedHello, $returnedJson['message'], 'la réponse est pas la bonne');
    }

    public function provideHelloPageSuffixes(): iterable
    {
        return [
            'common' => ['/bob', 'Hello bob!'],
            'empty' => ['', 'Hello World!'],
            'numeric' => ['/00000', 'Hello 00000!'],
        ];
    }
}
