<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubTheme;

class SubThemeSeeder extends Seeder
{
    public function run(): void
    {
        $subThemes = [
            [
                'code' => 1,
                'form_field_value' => 'cropVarieties',
                'full_name' => 'Crop Varieties, Increased Productivity and Production Management',
            ],
            [
                'code' => 2,
                'form_field_value' => 'seedSystems',
                'full_name' => 'Sustainable Seed Systems, Quality Assurance and Scalability',
            ],
            [
                'code' => 3,
                'form_field_value' => 'cropProtection',
                'full_name' => 'Plant Health, Emerging Crop Pests and Diseases, Biosecurity and Phytosanitary Systems',
            ],
            [
                'code' => 4,
                'form_field_value' => 'soilHealth',
                'full_name' => 'Plant Nutrition, Soil Health and Conservation Agriculture',
            ],
            [
                'code' => 5,
                'form_field_value' => 'waterSystems',
                'full_name' => 'Water Harvesting, Conservation and Irrigation Systems',
            ],
            [
                'code' => 6,
                'form_field_value' => 'organicCircular',
                'full_name' => 'Ecological-Organic Farming Systems, Renewable Energy Integration and Circular Economy',
            ],
            [
                'code' => 7,
                'form_field_value' => 'climateLand',
                'full_name' => 'Climate Change, Land Degradation and Reclamation',
            ],
            [
                'code' => 8,
                'form_field_value' => 'agrodiversity',
                'full_name' => 'Agrodiversity and Genetic Resources',
            ],
            [
                'code' => 9,
                'form_field_value' => 'animalFeeds',
                'full_name' => 'Animal Feed Resources, Nutrition and Husbandry Practices',
            ],
            [
                'code' => 10,
                'form_field_value' => 'livestockBreeding',
                'full_name' => 'Livestock Breeds, Breeding Practices and Emerging Livestock Species',
            ],
            [
                'code' => 11,
                'form_field_value' => 'animalHealth',
                'full_name' => 'Animal Health, Sanitary Systems and Emerging Livestock Pests and Diseases',
            ],
            [
                'code' => 12,
                'form_field_value' => 'apiculture',
                'full_name' => 'Apiculture, Beneficial Insects and Ecosystem Services',
            ],
            [
                'code' => 13,
                'form_field_value' => 'biotechnology',
                'full_name' => 'Biotechnological Solutions to Crop, Livestock and Natural Resource Management Challenges',
            ],
            [
                'code' => 14,
                'form_field_value' => 'foodSafety',
                'full_name' => 'Food Safety, Value Addition and Cottage Industries',
            ],
            [
                'code' => 15,
                'form_field_value' => 'mechanization',
                'full_name' => 'Mechanization in Agricultural Systems',
            ],
            [
                'code' => 16,
                'form_field_value' => 'techTransfer',
                'full_name' => 'Technology Transfer Approaches, Knowledge Co-Creation and Scaling Pathways, ICT-Enabled Precision Systems',
            ],
            [
                'code' => 17,
                'form_field_value' => 'agribusiness',
                'full_name' => 'Agribusiness, Financing, Policy, Adoption, and Socio-Economic Dimensions',
            ],
        ];

        foreach ($subThemes as $subTheme) {
            SubTheme::updateOrCreate(
                ['code' => $subTheme['code']],
                $subTheme
            );
        }
    }
}
