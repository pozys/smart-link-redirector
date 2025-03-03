<?php

namespace Database\Factories\Domain\Models;

use App\Domain\Models\ConditionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionValueFactory extends Factory
{
    protected $model = ConditionValue::class;

    public function definition(): array
    {
        return [
            'value' => 'en'
        ];
    }
}
