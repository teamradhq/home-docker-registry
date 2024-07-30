<?php

namespace Database\Factories\Docker;

use App\Models\Docker\Repository;
use App\Models\Docker\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'repository_id' => Repository::factory(),
            'name' => fake()->unique()->word,
            'digest' => fake()->sha256,
        ];
    }
}
