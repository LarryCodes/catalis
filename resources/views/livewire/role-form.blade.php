<div>
    <div class="form-group" style="margin-bottom: 16px;">
        <label for="name" style="display: block; margin-bottom: 6px; font-weight: 500;">Role Name *</label>
        <input type="text" id="name" wire:model="name" placeholder="Enter role name" 
               style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.875rem;"
               @if($role && $role->name === 'Super Admin') readonly @endif>
        @error('name') <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 500;">Assign Permissions</label>
        <div style="max-height: 300px; overflow-y: auto; border: 1px solid #e0e0e0; border-radius: 4px; padding: 12px;">
            @foreach($this->groupedPermissions as $resource => $permissions)
                <div style="margin-bottom: 16px;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; text-transform: capitalize; margin-bottom: 8px; color: #333; border-bottom: 1px solid #eee; padding-bottom: 4px;">
                        {{ $resource }}
                    </h4>
                    <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                        @foreach($permissions as $permission)
                            <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; min-width: 150px;">
                                <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->id }}"
                                       style="width: 14px; height: 14px;">
                                <span style="font-size: 0.8rem;">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        @error('selectedPermissions') <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions" style="display: flex; gap: 12px; justify-content: flex-end;">
        <button type="button" wire:click="$parent.closeForm" 
                style="padding: 10px 20px; background: #f5f5f5; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer;">
            Cancel
        </button>
        <button type="button" wire:click="save" 
                style="padding: 10px 20px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
            {{ $role ? 'Update Role' : 'Create Role' }}
        </button>
    </div>
</div>
