<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PtopCategory;
use App\Models\PtopSubCategory;

class PtopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Construction' => [
                'Developer (JV Partner)',
                'Construction Contractor',
                'Site Supervisor',
                'Civil Engineer',
                'Structural Engineer',
                'Mason / Bricklayer',
                'Tiler',
                'POP / Ceiling Installer',
                'Glass & Aluminum Installer',
                'Door/Window Installer',
                'Welders & Metal Fabricators',
            ],
            'Furnishing' => [
                'Interior Finisher',
                'Furniture Supplier',
                'Wardrobe Installer',
                'Kitchen Cabinet Specialist',
                'Curtain/Blind Installer',
                'Lighting/Fittings Supplier',
            ],
            'Utilities & Installation' => [
                'Electrician',
                'Plumber',
                'Solar Power / Inverter Installer',
                'CCTV/Surveillance Installer',
                'Generator Supplier',
                'Water System Installer (Borehole/Water Treatment)',
                'AC/Heating Technician (HVAC)',
            ],
            'Design & Planning' => [
                'Architect',
                'Land Surveyor',
                'Town Planner',
                'Landscape Designer',
                '3D Visualizer / Architectural Renderer',
                'Quantity Surveyor (QS)',
                'Building Estimator',
            ],
            'Legal & Finance' => [
                'Real Estate Investor',
                'Private Lender',
                'Legal Consultant',
                'Insurance Agent',
                'Valuer / Appraiser',
            ],
            'Real Estate Services' => [
                'Real Estate Agent / Realtor',
                'Property Manager',
                'Facilities Management Expert',
                'Marketing & Branding Expert',
            ],
            'Post-Construction Services' => [
                'Cleaning & Handover Services',
                'Post-Construction Waste Removal',
                'Snagging & Final Inspection Consultant',
            ],
        ];

        foreach ($categories as $category => $subcategories) {
            $parent = PtopCategory::create(['name' => $category]);

            foreach ($subcategories as $sub) {
                PtopSubCategory::create([
                    'ptop_category_id' => $parent->id,
                    'name' => $sub,
                ]);
            }
        }
    }
}
