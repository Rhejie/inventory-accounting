<?php

namespace Database\Factories\Sale;

use App\Models\Sale\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $amount = $this->faker->numberBetween($min=50,$max=500);
        $vat =  $this->faker->numberBetween($min=1,$max=10);
        $discount = $this->faker->numberBetween($min=5, $max=40);
        $tendered = $this->faker->numberBetween($min=600,$max=1000);
        $total = $amount + $vat - $discount;
        $change = $tendered - $total;

        return [
            'date' => $this->faker->dateTimeBetween('-1year','now'),
            'customer' => $this->faker->firstname(),
            'clerk' => 'Clerk01',
            'amount' => $amount,
            'vat' => $vat,
            'discount' => $discount,
            'discount_type' => $this->faker->randomElement(['Senior Card','Loyalty Card', 'Promo Card']),
            'tendered' => $tendered,
            'change' => $change
        ];
    }
}
