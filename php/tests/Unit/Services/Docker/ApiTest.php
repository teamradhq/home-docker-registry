<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Docker;

use App\Services\Docker\Api;
use App\Services\Docker\Client;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiTest extends TestCase
{
    protected Client $client;

    protected Api $api;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client();
        $this->api = new Api();
    }

    public function testVersionOk(): void
    {
        $this->assertEquals('OK', $this->api->version());
    }

    public function testVersionError(): void
    {
        Http::fake(['http://registry:5000/v2/' => Http::response('', 500)]);

        $this->assertEquals('ERROR - 500', $this->api->version());
    }

    public function testCatalogOk(): void
    {
        $catalog = $this->api->catalog();

        $this->assertGreaterThanOrEqual(2, $catalog['repositories']);
    }

    public function testCatalogError(): void
    {
        Http::fake(['http://registry:5000/v2/_catalog' => Http::response('', 500)]);

        $catalog = $this->api->catalog();

        $this->assertEquals(['error' => 'ERROR - 500'], $catalog);
    }
}
