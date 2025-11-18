<?php

namespace Database\Factories;

use App\Services\QrCodeService;
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
            'product_name' => $this->faker->name(),
            'batch_number' => $this->faker->randomNumber(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Product $product) {
            $qrCodeService = new QrCodeService();
            $product->qr_code = $qrCodeService->generate($product);
            $product->save();
        });
    }
}
