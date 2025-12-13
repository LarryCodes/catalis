<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class PeopleController extends Controller
{
    public function __invoke(): View
    {
        $people = $this->samplePeople();

        return view('people', compact('people'));
    }

    protected function samplePeople(): Collection
    {
        $records = [
            [
                'id' => 1,
                'employee_number' => 'EMP-001',
                'full_name' => 'Amina Kato',
                'nationality' => 'Ugandan',
                'gender' => 'Female',
                'date_of_birth' => Carbon::parse('1992-04-18'),
                'department' => ['name' => 'Operations'],
                'site' => ['site_name' => 'Kampala HQ'],
                'employeeType' => ['name' => 'Full Time'],
                'phone' => '+256 700 000001',
                'email' => 'amina@example.com',
                'address' => 'Plot 12, Kampala',
                'daily_wage' => 45000,
                'is_active' => true,
            ],
            [
                'id' => 2,
                'employee_number' => 'EMP-002',
                'full_name' => 'John Mugisha',
                'nationality' => 'Ugandan',
                'gender' => 'Male',
                'date_of_birth' => Carbon::parse('1988-11-05'),
                'department' => ['name' => 'Security'],
                'site' => ['site_name' => 'Entebbe'],
                'employeeType' => ['name' => 'Contract'],
                'phone' => '+256 701 222333',
                'email' => 'john@example.com',
                'address' => 'Entebbe Rd',
                'daily_wage' => 38000,
                'is_active' => false,
            ],
            [
                'id' => 3,
                'employee_number' => 'EMP-003',
                'full_name' => 'Linda Nansubuga',
                'nationality' => 'Ugandan',
                'gender' => 'Female',
                'date_of_birth' => Carbon::parse('1995-01-24'),
                'department' => ['name' => 'Finance'],
                'site' => ['site_name' => 'Mbarara'],
                'employeeType' => ['name' => 'Part Time'],
                'phone' => '+256 702 555777',
                'email' => null,
                'address' => 'Mbarara City',
                'daily_wage' => 42000,
                'is_active' => true,
            ],
        ];

        return collect($records)->map(function (array $record) {
            $record['department'] = (object) $record['department'];
            $record['site'] = (object) $record['site'];
            $record['employeeType'] = (object) $record['employeeType'];

            return (object) $record;
        });
    }
}
