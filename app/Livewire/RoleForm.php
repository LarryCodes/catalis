<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleForm extends Component
{
    public ?Role $role = null;
    
    public $name = '';
    public $selectedPermissions = [];

    public function mount(?Role $role = null)
    {
        $this->role = $role;
        
        if ($role) {
            $this->name = $role->name;
            $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        }
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'selectedPermissions' => 'array',
        ];
    }

    public function getGroupedPermissionsProperty()
    {
        $permissions = Permission::orderBy('name')->get();
        
        $grouped = [];
        foreach ($permissions as $permission) {
            $parts = explode('-', $permission->name);
            $action = $parts[0] ?? 'other';
            $resource = $parts[1] ?? 'general';
            
            if (!isset($grouped[$resource])) {
                $grouped[$resource] = [];
            }
            $grouped[$resource][] = $permission;
        }
        
        ksort($grouped);
        return $grouped;
    }

    public function save()
    {
        $this->validate();

        if ($this->role) {
            if (!auth()->user()->can('manage-roles')) {
                abort(403);
            }
            
            if ($this->role->name === 'Super Admin' && $this->name !== 'Super Admin') {
                session()->flash('error', 'Cannot rename the Super Admin role.');
                return;
            }
            
            $this->role->update(['name' => $this->name]);
            $this->role->syncPermissions(Permission::whereIn('id', $this->selectedPermissions)->get());
            
            $message = 'Role updated successfully.';
        } else {
            if (!auth()->user()->can('manage-roles')) {
                abort(403);
            }
            
            $role = Role::create(['name' => $this->name]);
            $role->syncPermissions(Permission::whereIn('id', $this->selectedPermissions)->get());
            
            $message = 'Role created successfully.';
        }

        $this->dispatch('roleSaved', message: $message);
        $this->dispatch('closeForm');
    }

    public function render()
    {
        return view('livewire.role-form');
    }
}
