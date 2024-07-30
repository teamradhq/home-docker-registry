<?php

declare(strict_types=1);

namespace App\Services\Docker;

class Api
{
    public function version(): string
    {
        $response = Client::get('/');

        if (($status = $response->status()) === 200) {
            return 'OK';
        }

        return $this->error($status);
    }

    /**
     * @return array{error?: string, repositories?: string[]}
     */
    public function catalog(): array
    {
        $response = Client::get('/_catalog');

        if (($status = $response->status()) === 200) {
            return $response->json();
        }

        return ['error' => $this->error($status)];
    }

    private function error(int $status): string
    {
        return sprintf('ERROR - %d', $status);
    }
}
