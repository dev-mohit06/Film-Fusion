<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offers = [
            [
                'offer_name' => 'Summer Sale',
                'discount_percentage' => '20',
                'offer_code' => 'SUMMER20',
                'count' => '50',
            ],
            [
                'offer_name' => 'Back to School',
                'discount_percentage' => '15',
                'offer_code' => 'SCHOOL15',
                'count' => '30',
            ],
            [
                'offer_name' => 'Holiday Special',
                'discount_percentage' => '25',
                'offer_code' => 'HOLIDAY25',
                'count' => '75',
            ],
            [
                'offer_name' => 'New Year\'s Eve',
                'discount_percentage' => '30',
                'offer_code' => 'NYE30',
                'count' => '60',
            ],
            [
                'offer_name' => 'Spring Clearance',
                'discount_percentage' => '10',
                'offer_code' => 'SPRING10',
                'count' => '40',
            ],
        ];

        foreach ($offers as $offer) {
            Offer::factory()->create($offer);
        }
    }
}
