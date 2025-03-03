<?php

namespace Database\Factories\Domain\Models;

use App\Domain\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    protected $model = Link::class;

    public function definition(): array
    {
        return [
            'url' => $this->faker->url(),
        ];
    }
}
