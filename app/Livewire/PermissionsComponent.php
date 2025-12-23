<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionsComponent extends Component
{
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

    public function render()
    {
        return view('livewire.permissions-component');
    }
}
