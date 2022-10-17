<?php

namespace Database\Factories;

use App\Models\InvoiceProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceProduct>
 */
class InvoiceProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'invoice_id'=>rand(1,10),
            'product_id'=>rand(1,10),
            'unit_price'=>rand(20,500),
            'quantity'=>rand(1,20),
        ];
    }
}
