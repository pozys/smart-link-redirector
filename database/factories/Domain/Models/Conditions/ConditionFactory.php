<?php

namespace Database\Factories\Domain\Models\Conditions;

use App\Domain\Models\Conditions\{Condition, EqualCondition};
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionFactory extends Factory
{
    protected $model = Condition::class;

    public function definition(): array
    {
        return [
            'condition_type' => app(EqualCondition::class),
        ];
    }
}
