<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
           'number'=>'INV-000' . rand(0,100),
           'customer_id'=>rand(1,10),
           'invoice_date'=>$this->faker->date,
           'due_date'=>$this->faker->date,
           'reference'=>'REF-000' . rand(0,100),
           'terms_and_conditions'=>$this->faker->paragraph(2),
           'sub_total'=>$this->faker->numberBetween(150,1900),
           'sub_total'=>$this->faker->numberBetween(0,150),
           'total'=>$this->faker->numberBetween(300,2000),





        ];
    }
}
