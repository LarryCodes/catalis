<div>
    <!-- Role Name Section -->
    <div class="form-group" style="margin-bottom: 16px;">
        <label for="name">Role Name *</label>
        <input type="text" id="name" wire:model="name" placeholder="e.g., HR Manager, Finance Officer"
               @if($role && $role->name === 'Super Admin') readonly style="background: #f3f4f6;" @endif>
        @error('name') <span class="error">{{ $message }}</span> @enderror
    </div>

    <!-- Permissions Section -->
    <div style="margin-bottom: 16px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <label style="font-weight: 500;">Permissions</label>
            <span style="font-size: 0.75rem; color: #6b7280;">{{ count($selectedPermissions) }} selected</span>
        </div>
        
        @foreach($this->groupedPermissions as $resource => $permissions)
            @php
                $permissionIds = collect($permissions)->pluck('id')->toArray();
                $selectedCount = count(array_intersect($selectedPermissions, $permissionIds));
                $allSelected = $selectedCount === count($permissionIds);
                $someSelected = $selectedCount > 0 && !$allSelected;
            @endphp
            <div class="accordion-section">
                <button type="button" class="accordion-header" wire:click="toggleSection('{{ $resource }}')">
                    <span class="accordion-title">
                        <span class="accordion-icon">{{ isset($openSections[$resource]) && $openSections[$resource] ? '−' : '+' }}</span>
                        {{ ucwords(str_replace('-', ' ', $resource)) }}
                    </span>
                    <span class="accordion-status">
                        @if($allSelected)
                            <span class="status-complete">✓ All</span>
                        @elseif($someSelected)
                            <span style="color: #007bff; font-size: 0.75rem;">{{ $selectedCount }}/{{ count($permissions) }}</span>
                        @else
                            <span class="status-optional">{{ count($permissions) }} available</span>
                        @endif
                        <label style="margin-left: 12px; cursor: pointer;" onclick="event.stopPropagation();">
                            <input type="checkbox" 
                                   wire:click="togglePermissionGroup('{{ $resource }}')"
                                   @if($allSelected) checked @endif
                                   style="width: 16px; height: 16px; accent-color: #007bff; cursor: pointer;">
                        </label>
                    </span>
                </button>
                <div class="accordion-content" x-show="$wire.openSections && $wire.openSections['{{ $resource }}']" x-collapse>
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @foreach($permissions as $permission)
                            @php
                                $isSelected = in_array($permission->id, $selectedPermissions);
                            @endphp
                            <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; padding: 6px 12px; background: {{ $isSelected ? '#dbeafe' : '#f9fafb' }}; border: 1px solid {{ $isSelected ? '#3b82f6' : '#e0e0e0' }}; border-radius: 4px; font-size: 0.8rem;">
                                <input type="checkbox" 
                                       wire:model.live="selectedPermissions" 
                                       value="{{ $permission->id }}"
                                       style="width: 14px; height: 14px; accent-color: #007bff; cursor: pointer;">
                                <span style="color: {{ $isSelected ? '#1e40af' : '#333' }};">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
        @error('selectedPermissions') <span class="error">{{ $message }}</span> @enderror
    </div>

    <!-- Action Buttons -->
    <div class="form-actions">
        <button type="button" wire:click="$parent.closeForm" class="btn-cancel">Cancel</button>
        <button type="button" wire:click="save" class="btn-save">{{ $role ? 'Update Role' : 'Create Role' }}</button>
    </div>
</div>
