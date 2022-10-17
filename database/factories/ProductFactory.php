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
            'code'=>'PC-'. rand(10,200),
            'name'=>$this->faker->sentence(2),
            'unite_price'=>mt_rand(200,3000),
            'description'=>$this->faker->text(30),
            'image'=>$this->faker->imageUrl(),
            'available'=>rand(0,1),
        ];
    }
}
