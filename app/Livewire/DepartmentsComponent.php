<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Partner;
use Livewire\Component;
use Livewire\Attributes\On;

class DepartmentsComponent extends Component
{
    public $search = '';
    public $selectedPartnerId = null;
    public $showForm = false;
    public $editingDepartment = null;

    #[On('departmentSaved')]
    public function refreshList($message = null)
    {
        $this->showForm = false;
        $this->editingDepartment = null;
        if ($message) {
            session()->flash('message', $message);
        }
    }

    #[On('searchDepartments')]
    public function handleSearch($search)
    {
        $this->search = $search;
    }

    #[On('openCreateDepartment')]
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
        // Livewire handles reactivity
    }

    public function updatedSelectedPartnerId()
    {
        $this->showForm = false;
        $this->editingDepartment = null;
    }

    public function openCreateForm()
    {
        if (!auth()->user()->can('create-departments')) {
            abort(403);
        }
        if (!$this->selectedPartnerId || $this->selectedPartnerId === 'all') {
            session()->flash('error', 'Please select a partner first.');
            return;
        }
        $this->showForm = true;
        $this->editingDepartment = null;
    }

    public function openEditForm($departmentId)
    {
        if (!auth()->user()->can('edit-departments')) {
            abort(403);
        }
        $this->editingDepartment = Department::find($departmentId);
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingDepartment = null;
    }

    public function deactivateDepartment($departmentId)
    {
        if (!auth()->user()->can('delete-departments')) {
            abort(403);
        }
        $department = Department::find($departmentId);
        if ($department) {
            $department->update(['active' => false]);
            session()->flash('message', 'Department deactivated successfully.');
        }
    }

    public function render()
    {
        $partners = Partner::active()->orderBy('company_name')->get();
        
        $departments = collect();
        if ($this->selectedPartnerId) {
            if ($this->selectedPartnerId === 'all') {
                $query = Department::with('partner')
                    ->withCount(['employees' => fn($q) => $q->where('active', true)])
                    ->active();
            } else {
                $query = Department::where('partner_id', $this->selectedPartnerId)
                    ->withCount(['employees' => fn($q) => $q->where('active', true)])
                    ->active();
            }
            
            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            }
            
            $departments = $query->orderBy('name')->get();
        }

        return view('livewire.departments-component', [
            'partners' => $partners,
            'departments' => $departments,
        ]);
    }
}
