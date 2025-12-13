<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class PayrollController extends Controller
{
    public function __invoke(): View
    {
        $payrolls = $this->samplePayrolls();

        return view('payroll', compact('payrolls'));
    }

    protected function samplePayrolls(): Collection
    {
        $rows = [
            [
                'employee_id' => 'EMP-010',
                'full_name' => 'James Oryem',
                'gender' => 'Male',
                'date_of_birth' => Carbon::parse('1990-02-14'),
                'nationality' => 'Ugandan',
                'phone' => '+256 703 000010',
                'email' => 'james@example.com',
                'address' => 'Jinja Rd',
                'site' => ['site_name' => 'Kampala'],
                'tenure' => 'Full Time',
                'department' => ['name' => 'Operations'],
                'position' => 'Supervisor',
            ],
            [
                'employee_id' => 'EMP-011',
                'full_name' => 'Grace Namaganda',
                'gender' => 'Female',
                'date_of_birth' => Carbon::parse('1994-07-03'),
                'nationality' => 'Ugandan',
                'phone' => '+256 704 111222',
                'email' => null,
                'address' => 'Gulu',
                'site' => ['site_name' => 'Gulu'],
                'tenure' => 'Contract',
                'department' => ['name' => 'Finance'],
                'position' => 'Officer',
            ],
        ];

        return collect($rows)->map(function (array $row) {
            $row['site'] = (object) $row['site'];
            $row['department'] = (object) $row['department'];

            return (object) $row;
        });
    }
}
