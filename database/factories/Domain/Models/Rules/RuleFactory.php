<?php

namespace Database\Factories\Domain\Models\Rules;

use App\Domain\Models\Rules\{LanguageRule, Rule};
use Illuminate\Database\Eloquent\Factories\Factory;

class RuleFactory extends Factory
{
    protected $model = Rule::class;

    public function definition(): array
    {
        return [
            'rule_type' => app(LanguageRule::class),
        ];
    }
}
