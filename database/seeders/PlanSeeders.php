<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'plan_name' => "Premium Mini",
                'features' => "Watch online, Unlock all features from our site, Daily content updates",
                'plan_price' => 199,
                'plan_duration' => 1,
            ],
            [
                'plan_name' => "Ultimate",
                'features' => "Watch online, Unlock all features from our site, Daily content updates",
                'plan_price' => 399,
                'plan_duration' => 3,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::factory()->create($planData);
        }
    }
}