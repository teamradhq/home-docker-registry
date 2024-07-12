<?php

namespace Tests\Unit\Services\Docker;

use App\Services\Docker\Client;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ClientTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client();
    }

    public function testVersionOk(): void
    {
        $this->assertEquals('OK', $this->client->version());
    }

    public function testVersionError(): void
    {
        Http::fake([
            'http://registry:5000/v2/' => Http::response('', 500),
        ]);

        $this->assertEquals('ERROR - 500', $this->client->version());
    }

    public function testCatalogOk(): void
    {
        $catalog = $this->client->catalog();

        $this->assertCount(0, $catalog['repositories']);
    }

    public function testCatalogError(): void
    {
        Http::fake([
            'http://registry:5000/v2/_catalog' => Http::response('', 500),
        ]);

        $catalog = $this->client->catalog();

        $this->assertEquals(['error' => 'ERROR - 500'], $catalog);
    }
}
