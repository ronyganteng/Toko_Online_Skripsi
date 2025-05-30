<?php

namespace Database\Factories;
use App\Models\product;
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
    public function definition(): array
    {
        return [
            'sku'           => Str::random(10),
            'nama_product'  => fake()->name(),
            'type'          => "Salib", // password
            'kategory'      => "Kayu",
            'harga'         => 200000,
            'quantity'      => 10,
            'discount'      => 10 / 100,
            'is_active'     => 1,
            'foto'          => fake()->name(),
        ];
    }
}
