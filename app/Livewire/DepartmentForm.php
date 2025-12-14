<?php

namespace App\Livewire;

use App\Models\Department;
use Livewire\Component;

class DepartmentForm extends Component
{
    public ?Department $department = null;
    public $partner_id;
    public $name = '';
    public $description = '';

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function mount($department = null, $partnerId = null)
    {
        $this->partner_id = $partnerId;
        
        if ($department) {
            $this->department = $department;
            $this->partner_id = $department->partner_id;
            $this->name = $department->name;
            $this->description = $department->description ?? '';
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->department) {
            if (!auth()->user()->can('edit-departments')) {
                abort(403);
            }
            $this->department->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            $message = 'Department updated successfully.';
        } else {
            if (!auth()->user()->can('create-departments')) {
                abort(403);
            }
            Department::create([
                'partner_id' => $this->partner_id,
                'name' => $this->name,
                'description' => $this->description,
                'active' => true,
            ]);
            $message = 'Department added successfully.';
        }

        $this->dispatch('departmentSaved', message: $message);
        $this->dispatch('closeForm');
    }

    public function render()
    {
        return view('livewire.department-form');
    }
}
