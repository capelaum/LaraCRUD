<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'cover' => $this->faker->imageUrl(640, 480),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'description' => $this->faker->text(),
            'stock' => $this->faker->randomDigit(),
        ];
    }
}
