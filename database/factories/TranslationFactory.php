<?php

namespace Database\Factories;

use App\Models\Locale;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word(), // translation key
            'locale_id' => Locale::inRandomOrder()->first()->id ?? Locale::factory(),
            'value' => $this->faker->sentence(3), // translation text
        ];
    }
}
