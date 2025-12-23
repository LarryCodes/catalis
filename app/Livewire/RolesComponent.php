<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesComponent extends Component
{
    public $search = '';
    public $showForm = false;
    public $editingRole = null;

    #[On('roleSaved')]
    public function refreshList($message = null)
    {
        $this->showForm = false;
        $this->editingRole = null;
        if ($message) {
            session()->flash('message', $message);
        }
    }

    #[On('searchRoles')]
    public function handleSearch($search)
    {
        $this->search = $search;
    }

    #[On('openCreateRole')]
    public function handleOpenCreateForm()
    {
        $this->openCreateForm();
    }

    #[On('closeForm')]
    public function handleCloseForm()
    {
        $this->closeForm();
    }

    public function getRolesProperty()
    {
        return Role::query()
            ->withCount('permissions')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->get();
    }

    public function openCreateForm()
    {
        if (!auth()->user()->can('manage-roles')) {
            abort(403);
        }
        $this->showForm = true;
        $this->editingRole = null;
    }

    public function openEditForm($roleId)
    {
        if (!auth()->user()->can('manage-roles')) {
            abort(403);
        }
        $this->editingRole = Role::find($roleId);
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingRole = null;
    }

    public function deleteRole($roleId)
    {
        if (!auth()->user()->can('manage-roles')) {
            abort(403);
        }
        
        $role = Role::find($roleId);
        if ($role) {
            if ($role->name === 'Super Admin') {
                session()->flash('error', 'Cannot delete the Super Admin role.');
                return;
            }
            $role->delete();
            session()->flash('message', 'Role deleted successfully.');
        }
    }

    public function render()
    {
        return view('livewire.roles-component');
    }
}
