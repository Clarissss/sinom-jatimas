<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PublicContentSeeder extends Seeder
{
    public function run(): void
    {
        CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'PT. Sinom Jati Mas',
                'about_us' => 'PT. Sinom Jati Mas operates in General Contractor, Cut and Fill, and General Trading. We are committed to delivering trusted, on-time, and high-quality construction solutions for partners across Indonesia.',
                'vision' => 'PT. SINOM JATI MAS will become one of the best companies in Indonesia by emphasizing sustainable growth, human resource development, technology management, and good corporate governance—building a strong, resilient company that contributes to national progress.',
                'mission' => 'To increase competitiveness in the construction industry by developing the best services and technology for our partners and stakeholders; to improve HR training for a quality workforce, create a conducive work environment, and provide broad employment opportunities.',
                'address' => 'Link. Sukarela RT/RW 006/001, Kel. Mekarsari, Kec. Pulomerak',
                'email' => 'sinomjatimas@gmail.com',
                'phone' => '0877-7130-0570',
            ]
        );

        $services = [
            [
                'name' => 'General Contractor',
                'description' => 'General contracting for infrastructure, residential, and commercial projects with high safety and quality standards.',
            ],
            [
                'name' => 'General Trading',
                'description' => 'Supply of construction materials and project essentials through a trusted supplier network at competitive prices.',
            ],
            [
                'name' => 'Cut and Fill',
                'description' => 'Earthworks and site preparation to support road, housing, and industrial area development.',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($service['name'])],
                array_merge($service, ['is_active' => true])
            );
        }

        $partners = [
            'Nusantara Construction Partners',
            'Jaya Material Supply Co.',
            'Prima Sejahtera Development',
        ];

        foreach ($partners as $name) {
            Partner::firstOrCreate(
                ['name' => $name],
                ['logo' => '', 'is_active' => true]
            );
        }

        $demoClient = User::firstOrCreate(
            ['email' => 'client@demo.sinomjatimas.com'],
            [
                'name' => 'Demo Client',
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );

        $sampleProjects = [
            [
                'name' => 'Residential Road Works',
                'description' => 'Construction and asphalt paving of modern residential access roads with integrated drainage.',
                'location' => 'Cilegon, Banten',
                'status' => 'in_progress',
                'progress_percentage' => 75,
            ],
            [
                'name' => 'Industrial Zone Cut and Fill',
                'description' => 'Land preparation and cut-and-fill works for an industrial area.',
                'location' => 'Serang, Banten',
                'status' => 'in_progress',
                'progress_percentage' => 45,
            ],
            [
                'name' => 'Site Infrastructure Renovation',
                'description' => 'Repair and upgrade of supporting infrastructure at the construction site.',
                'location' => 'Tangerang, Banten',
                'status' => 'completed',
                'progress_percentage' => 100,
            ],
        ];

        foreach ($sampleProjects as $project) {
            Project::updateOrCreate(
                [
                    'name' => $project['name'],
                    'client_id' => $demoClient->id,
                ],
                array_merge($project, [
                    'contract_value' => 500000000,
                ])
            );
        }

        $this->command->info('Public page content (profile, services, partners, demo projects) seeded successfully.');
    }
}
