<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Docker;

use App\Services\Docker\Client;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;

class ClientTest extends TestCase
{
    protected Client $client;

    public static function methodProvider(): array
    {
        return [
            'GET' => ['get'],
            'POST' => ['post'],
            'PATCH' => ['patch'],
            'PUT' => ['put'],
            'DELETE' => ['delete'],
        ];
    }

    #[TestDox('The client should make a $_dataName request to the registry.')]
    #[DataProvider('methodProvider')]
    public function testGet(string $method): void
    {
        Http::fake(function ($request) {
            $this->assertStringStartsWith('http://registry:5000/v2/path', $request->url());

            return Http::response('test');
        });
        $res = Client::$method('/path', ['query' => 'value']);

        $this->assertEquals('test', $res->body());
    }
}
