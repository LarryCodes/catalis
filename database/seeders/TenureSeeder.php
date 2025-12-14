<?php

namespace Database\Seeders;

use App\Models\Tenure;
use Illuminate\Database\Seeder;

class TenureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenures = [
            [
                'name' => 'Full Time',
                'description' => 'Employees working standard full-time hours (typically 40 hours per week)',
                'active' => true,
            ],
            [
                'name' => 'Part Time',
                'description' => 'Employees working reduced hours compared to full-time (typically less than 40 hours per week)',
                'active' => true,
            ],
            [
                'name' => 'Casual',
                'description' => 'Employees engaged on an as-needed basis without guaranteed hours',
                'active' => true,
            ],
        ];

        foreach ($tenures as $tenure) {
            Tenure::firstOrCreate(
                ['name' => $tenure['name']],
                $tenure
            );
        }

        $this->command->info('Tenures seeded successfully!');
    }
}
