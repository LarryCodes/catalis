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
        $partners = $this->samplePartners();

        return view('people', compact('people', 'partners'));
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

    protected function samplePartners(): Collection
    {
        $records = [
            [
                'id' => 1,
                'name' => 'Vertex Logistics',
                'code' => 'CL-001',
                'primary_contact' => 'Moses Katongole',
                'email' => 'moses@vertexlogistics.com',
                'phone' => '+256 777 111222',
                'sites' => ['Kampala CBD', 'Namanve'],
                'active_headcount' => 152,
                'sla_tier' => 'Premium',
                'status' => 'Active',
            ],
            [
                'id' => 2,
                'name' => 'Serenity Hospitals',
                'code' => 'CL-002',
                'primary_contact' => 'Dr. Ruth Kasse',
                'email' => 'rkasse@serenityhospital.org',
                'phone' => '+256 778 555000',
                'sites' => ['Bukoto', 'Ntinda'],
                'active_headcount' => 87,
                'sla_tier' => 'Standard',
                'status' => 'Pending',
            ],
            [
                'id' => 3,
                'name' => 'Northern Agro Supply',
                'code' => 'CL-003',
                'primary_contact' => 'Andrew Obua',
                'email' => 'andrew@northernagro.co.ug',
                'phone' => '+256 706 412890',
                'sites' => ['Gulu', 'Lira', 'Kitgum'],
                'active_headcount' => 236,
                'sla_tier' => 'Premium',
                'status' => 'Active',
            ],
        ];

        return collect($records)->map(fn ($record) => (object) $record);
    }
}
