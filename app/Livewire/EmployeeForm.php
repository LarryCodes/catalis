<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Partner;
use App\Models\Site;
use App\Models\Department;
use App\Models\Tenure;
use Livewire\Component;
use Illuminate\Validation\Rule;

class EmployeeForm extends Component
{
    public ?Employee $employee = null;
    
    // Employment Details
    public $partner_id = '';
    public $site_id = '';
    public $department_id = '';
    public $tenure_id = '';
    public $shift_id = null;
    
    // Personal Information
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $date_of_birth = '';
    public $nationality = '';
    public $national_id_number = '';
    public $nssf_number = '';
    public $tin_number = '';
    public $marital_status = '';
    
    // Next of Kin
    public $next_of_kin_name = '';
    public $next_of_kin_relationship = '';
    public $next_of_kin_phone = '';
    public $next_of_kin_address = '';
    
    // Address
    public $address = '';
    public $district = '';
    public $area_lc1 = '';
    
    // Banking
    public $bank_name = '';
    public $bank_branch = '';
    public $bank_account_name = '';
    public $bank_account_number = '';
    
    // Compensation
    public $daily_wage = '';
    public $management_fee = '';

    // Accordion state
    public $openSections = ['employment' => true, 'personal' => false, 'contact' => false, 'nextOfKin' => false, 'banking' => false, 'compensation' => false];

    public function rules()
    {
        $employeeId = $this->employee?->id;
        
        return [
            // Employment Details
            'partner_id' => 'required|exists:partners,id',
            'site_id' => 'required|exists:sites,id',
            'department_id' => 'required|exists:departments,id',
            'tenure_id' => 'required|exists:tenures,id',
            'shift_id' => 'nullable|exists:shifts,id',
            
            // Personal Information
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('employees')->ignore($employeeId)],
            'phone' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'national_id_number' => ['required', 'string', Rule::unique('employees')->ignore($employeeId)],
            'nssf_number' => 'nullable|string|max:255',
            'tin_number' => 'nullable|string|max:255',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            
            // Next of Kin
            'next_of_kin_name' => 'required|string|max:255',
            'next_of_kin_relationship' => 'required|string|max:255',
            'next_of_kin_phone' => 'required|string|max:255',
            'next_of_kin_address' => 'required|string',
            
            // Address
            'address' => 'required|string',
            'district' => 'required|string|max:255',
            'area_lc1' => 'required|string|max:255',
            
            // Banking (optional)
            'bank_name' => 'nullable|string|max:255',
            'bank_branch' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            
            // Compensation
            'daily_wage' => 'required|numeric|min:0',
            'management_fee' => 'nullable|numeric|min:0',
        ];
    }

    public function mount($employee = null)
    {
        if ($employee) {
            $this->employee = $employee;
            $this->partner_id = $employee->partner_id;
            $this->site_id = $employee->site_id;
            $this->department_id = $employee->department_id;
            $this->tenure_id = $employee->tenure_id;
            $this->shift_id = $employee->shift_id;
            $this->first_name = $employee->first_name;
            $this->last_name = $employee->last_name;
            $this->email = $employee->email ?? '';
            $this->phone = $employee->phone;
            $this->date_of_birth = $employee->date_of_birth?->format('Y-m-d');
            $this->nationality = $employee->nationality;
            $this->national_id_number = $employee->national_id_number;
            $this->nssf_number = $employee->nssf_number ?? '';
            $this->tin_number = $employee->tin_number ?? '';
            $this->marital_status = $employee->marital_status;
            $this->next_of_kin_name = $employee->next_of_kin_name;
            $this->next_of_kin_relationship = $employee->next_of_kin_relationship;
            $this->next_of_kin_phone = $employee->next_of_kin_phone;
            $this->next_of_kin_address = $employee->next_of_kin_address;
            $this->address = $employee->address;
            $this->district = $employee->district;
            $this->area_lc1 = $employee->area_lc1;
            $this->bank_name = $employee->bank_name ?? '';
            $this->bank_branch = $employee->bank_branch ?? '';
            $this->bank_account_name = $employee->bank_account_name ?? '';
            $this->bank_account_number = $employee->bank_account_number ?? '';
            $this->daily_wage = $employee->daily_wage;
            $this->management_fee = $employee->management_fee ?? '';
        }
    }

    public function updatedPartnerId()
    {
        $this->site_id = '';
        $this->department_id = '';
    }

    public function toggleSection($section)
    {
        $this->openSections[$section] = !$this->openSections[$section];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'partner_id' => $this->partner_id,
            'site_id' => $this->site_id,
            'department_id' => $this->department_id,
            'tenure_id' => $this->tenure_id,
            'shift_id' => $this->shift_id ?: null,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email ?: null,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'nationality' => $this->nationality,
            'national_id_number' => $this->national_id_number,
            'nssf_number' => $this->nssf_number ?: null,
            'tin_number' => $this->tin_number ?: null,
            'marital_status' => $this->marital_status,
            'next_of_kin_name' => $this->next_of_kin_name,
            'next_of_kin_relationship' => $this->next_of_kin_relationship,
            'next_of_kin_phone' => $this->next_of_kin_phone,
            'next_of_kin_address' => $this->next_of_kin_address,
            'address' => $this->address,
            'district' => $this->district,
            'area_lc1' => $this->area_lc1,
            'bank_name' => $this->bank_name ?: null,
            'bank_branch' => $this->bank_branch ?: null,
            'bank_account_name' => $this->bank_account_name ?: null,
            'bank_account_number' => $this->bank_account_number ?: null,
            'daily_wage' => $this->daily_wage,
            'management_fee' => $this->management_fee ?: null,
        ];

        if ($this->employee) {
            if (!auth()->user()->can('edit-employees')) {
                abort(403);
            }
            $this->employee->update($data);
            $message = 'Employee updated successfully.';
        } else {
            if (!auth()->user()->can('create-employees')) {
                abort(403);
            }
            Employee::create($data);
            $message = 'Employee added successfully.';
        }

        $this->dispatch('employeeSaved', message: $message);
        $this->dispatch('closeForm');
    }

    public function render()
    {
        $partners = Partner::active()->orderBy('company_name')->get();
        $tenures = Tenure::active()->orderBy('name')->get();
        
        $sites = collect();
        $departments = collect();
        if ($this->partner_id) {
            $sites = Site::where('partner_id', $this->partner_id)->active()->orderBy('name')->get();
            $departments = Department::where('partner_id', $this->partner_id)->active()->orderBy('name')->get();
        }

        return view('livewire.employee-form', [
            'partners' => $partners,
            'sites' => $sites,
            'departments' => $departments,
            'tenures' => $tenures,
            'maritalStatuses' => ['Single', 'Married', 'Divorced', 'Widowed'],
        ]);
    }
}
