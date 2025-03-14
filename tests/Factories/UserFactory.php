<?php

declare(strict_types=1);

namespace Tests\Factories;

use App\Domain\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class UserFactory
{
    public static function make(array $extra = []): User
    {
        $definition = [...self::definition(), ...$extra];

        return new User($definition);
    }

    private static function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
