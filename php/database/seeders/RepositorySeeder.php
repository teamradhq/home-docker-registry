<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Docker\Repository;
use Illuminate\Database\Seeder;

class RepositorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Repository::factory()
            ->count(10)
            ->hasTags(fake()->numberBetween(2, 25))
            ->create();

        Repository::all()->each(function (Repository $repository): void {
            if (!$repository->tags->where('name', 'latest')->first()) {
                $repository->tags()->create([
                    'name' => 'latest',
                    'digest' => fake()->sha256,
                ]);
            }
        });
    }
}
