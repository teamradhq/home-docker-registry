<?php

namespace App\Services\Docker;

use Illuminate\Support\Facades\Http;

class Client
{
    public readonly string $scheme;
    public readonly string $host;
    public readonly int $port;

    public function __construct()
    {
        $this->scheme = 'http';
        $this->host = 'registry';
        $this->port = 5000;
    }

    public function version(): string {
        $response = $this->request('v2/');

        if (($status = $response->status()) === 200) {
            return 'OK';
        }

        return $this->error($status);
    }

    public function catalog(): array {
        $response = $this->request('v2/_catalog');

        if (($status = $response->status()) === 200) {
            return $response->json();
        }

        return ['error' => $this->error($status)];
    }

    private function request(string $path) {
        $uri = sprintf('%s://%s:%d/%s', $this->scheme, $this->host, $this->port, $path);

        return Http::get($uri);
    }

    private function error(int $status): string {
        return sprintf('ERROR - %d', $status);
    }
}
