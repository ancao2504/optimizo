<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'price' => 0,
                'description' => 'Basic access with limited features',
                'features' => [
                    'Access to basic tools',
                    'Limited conversions per month',
                    'Standard support',
                ],
                'tool_limits' => [
                    'pdf_conversions' => 10,
                    'image_conversions' => 20,
                    'document_conversions' => 10,
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'price' => 9.99,
                'description' => 'Professional plan with extended limits',
                'features' => [
                    'Access to all tools',
                    'Extended conversion limits',
                    'Priority support',
                    'No ads',
                ],
                'tool_limits' => [
                    'pdf_conversions' => 100,
                    'image_conversions' => 200,
                    'document_conversions' => 100,
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'price' => 29.99,
                'description' => 'Unlimited access for businesses',
                'features' => [
                    'Unlimited access to all tools',
                    'Unlimited conversions',
                    'Premium support',
                    'API access',
                    'Custom branding',
                ],
                'tool_limits' => [
                    'pdf_conversions' => -1, // -1 means unlimited
                    'image_conversions' => -1,
                    'document_conversions' => -1,
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::firstOrCreate(
                ['slug' => $planData['slug']],
                $planData
            );
        }
    }
}
