<?php

declare(strict_types=1);

namespace App\Services\Docker;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

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

    /**
     * @param  string|array<string, string>|null  $query
     */
    public static function get(string $path, string|array|null $query = null): Response
    {
        return (new self)->request($path, $query);
    }

    /**
     * @param  string|array<string, string>|null  $data
     */
    public static function post(string $path, string|array|null $data = []): Response
    {
        return (new self)->request($path, $data, 'post');
    }

    /**
     * @param  string|array<string, string>|null  $data
     */
    public static function patch(string $path, string|array|null $data = []): Response
    {
        return (new self)->request($path, $data, 'patch');
    }

    /**
     * @param  string|array<string, string>|null  $data
     */
    public static function put(string $path, string|array|null $data = []): Response
    {
        return (new self)->request($path, $data, 'put');
    }

    /**
     * @param  string|array<string, string>|null  $data
     */
    public static function delete(string $path, string|array|null $data = []): Response
    {
        return (new self)->request($path, $data, 'delete');
    }

    /**
     * @param  string|array<string, string>|null  $data
     */
    private function request(string $path, array|string|null $data = [], string $method = 'get'): Response
    {
        return Http::{$this->method($method)}($this->uri($path), $data);
    }

    private function uri(string $path): string
    {
        return sprintf('%s://%s:%d/v2/%s', $this->scheme, $this->host, $this->port, ltrim($path, '/'));
    }

    private function method(string $method): string
    {
        $method = strtolower($method);

        return match ($method) {
            'get', 'post', 'patch', 'put', 'delete' => $method,
            default => throw new InvalidArgumentException(sprintf('Invalid method: %s', $method)),
        };
    }
}
