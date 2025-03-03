<?php

namespace Database\Factories\Domain\Models;

use App\Domain\Models\RedirectLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectLinkFactory extends Factory
{
    protected $model = RedirectLink::class;

    public function definition(): array
    {
        return [
            'url' => $this->faker->url(),
        ];
    }
}
