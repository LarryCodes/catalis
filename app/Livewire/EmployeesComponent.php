<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Partner;
use App\Models\Site;
use App\Models\Department;
use App\Models\Tenure;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class EmployeesComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $filterPartnerId = '';
    public $filterSiteId = '';
    public $filterDepartmentId = '';
    public $filterTenureId = '';
    public $showForm = false;
    public $editingEmployee = null;

    protected $queryString = ['search', 'filterPartnerId', 'filterSiteId', 'filterDepartmentId', 'filterTenureId'];

    #[On('employeeSaved')]
    public function refreshList($message = null)
    {
        $this->showForm = false;
        $this->editingEmployee = null;
        if ($message) {
            session()->flash('message', $message);
        }
    }

    #[On('searchEmployees')]
    public function handleSearch($search)
    {
        $this->search = $search;
    }

    #[On('openCreateEmployee')]
    public function handleOpenCreateForm()
    {
        $this->openCreateForm();
    }

    #[On('closeForm')]
    public function handleCloseForm()
    {
        $this->closeForm();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterPartnerId()
    {
        $this->filterSiteId = '';
        $this->filterDepartmentId = '';
        $this->resetPage();
    }

    public function updatedFilterSiteId()
    {
        $this->resetPage();
    }

    public function updatedFilterDepartmentId()
    {
        $this->resetPage();
    }

    public function updatedFilterTenureId()
    {
        $this->resetPage();
    }

    public function openCreateForm()
    {
        if (!auth()->user()->can('create-employees')) {
            abort(403);
        }
        $this->showForm = true;
        $this->editingEmployee = null;
    }

    public function openEditForm($employeeId)
    {
        if (!auth()->user()->can('edit-employees')) {
            abort(403);
        }
        $this->editingEmployee = Employee::find($employeeId);
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingEmployee = null;
    }

    public function deactivateEmployee($employeeId)
    {
        if (!auth()->user()->can('delete-employees')) {
            abort(403);
        }
        $employee = Employee::find($employeeId);
        if ($employee) {
            $employee->update(['active' => false]);
            session()->flash('message', 'Employee deactivated successfully.');
        }
    }

    public function render()
    {
        $partners = Partner::active()->orderBy('company_name')->get();
        $tenures = Tenure::active()->orderBy('name')->get();
        
        // Sites and departments filtered by partner
        $sites = collect();
        $departments = collect();
        if ($this->filterPartnerId) {
            $sites = Site::where('partner_id', $this->filterPartnerId)->active()->orderBy('name')->get();
            $departments = Department::where('partner_id', $this->filterPartnerId)->active()->orderBy('name')->get();
        }

        $query = Employee::with(['partner', 'site', 'department', 'tenure'])->active();

        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('employee_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('national_id_number', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($this->filterPartnerId) {
            $query->where('partner_id', $this->filterPartnerId);
        }

        if ($this->filterSiteId) {
            $query->where('site_id', $this->filterSiteId);
        }

        if ($this->filterDepartmentId) {
            $query->where('department_id', $this->filterDepartmentId);
        }

        if ($this->filterTenureId) {
            $query->where('tenure_id', $this->filterTenureId);
        }

        $employees = $query->orderBy('first_name')->paginate(15);

        return view('livewire.employees-component', [
            'partners' => $partners,
            'sites' => $sites,
            'departments' => $departments,
            'tenures' => $tenures,
            'employees' => $employees,
        ]);
    }
}
