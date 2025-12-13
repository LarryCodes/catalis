<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class TimeAttendanceController extends Controller
{
    public function __invoke(): View
    {
        $shifts = $this->sampleShifts();

        return view('time_attendance', compact('shifts'));
    }

    protected function sampleShifts(): Collection
    {
        $rows = [
            [
                'employee_id' => 'EMP-020',
                'full_name' => 'Sarah Adoch',
                'gender' => 'Female',
                'date_of_birth' => Carbon::parse('1993-08-09'),
                'nationality' => 'Ugandan',
                'phone' => '+256 705 123456',
                'email' => 'sarah@example.com',
                'address' => 'Ntinda',
                'site' => ['site_name' => 'Ntinda'],
                'tenure' => 'Shift',
                'department' => ['name' => 'Field Ops'],
                'position' => 'Team Lead',
            ],
            [
                'employee_id' => 'EMP-021',
                'full_name' => 'Peter Kimera',
                'gender' => 'Male',
                'date_of_birth' => Carbon::parse('1991-05-22'),
                'nationality' => 'Ugandan',
                'phone' => '+256 706 444555',
                'email' => null,
                'address' => 'Masaka',
                'site' => ['site_name' => 'Masaka'],
                'tenure' => 'Night Shift',
                'department' => ['name' => 'Security'],
                'position' => 'Guard',
            ],
        ];

        return collect($rows)->map(function (array $row) {
            $row['site'] = (object) $row['site'];
            $row['department'] = (object) $row['department'];

            return (object) $row;
        });
    }
}
