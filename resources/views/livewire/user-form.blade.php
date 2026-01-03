<div>
    <!-- User Details Section -->
    <div style="margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 12px; padding-bottom: 6px; border-bottom: 1px solid #e5e7eb;">
            <span style="font-weight: 600; font-size: 0.85rem; color: #374151;">User Details</span>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label for="name" style="display: block; margin-bottom: 6px; font-weight: 500; font-size: 0.85rem; color: #374151;">
                    Full Name <span style="color: #dc2626;">*</span>
                </label>
                <input type="text" id="name" wire:model="name" placeholder="e.g., John Doe" 
                       style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.875rem; transition: all 0.2s;"
                       onfocus="this.style.borderColor='#007bff'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)';"
                       onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                @error('name') <span style="color: #dc2626; font-size: 0.7rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="email" style="display: block; margin-bottom: 6px; font-weight: 500; font-size: 0.85rem; color: #374151;">
                    Email Address <span style="color: #dc2626;">*</span>
                </label>
                <input type="email" id="email" wire:model="email" placeholder="e.g., john@company.com"
                       style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.875rem; transition: all 0.2s;"
                       onfocus="this.style.borderColor='#007bff'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)';"
                       onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                @error('email') <span style="color: #dc2626; font-size: 0.7rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <!-- Security Section -->
    <div style="margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 12px; padding-bottom: 6px; border-bottom: 1px solid #e5e7eb;">
            <span style="font-weight: 600; font-size: 0.85rem; color: #374151;">Security</span>
            @if($user)
                <span style="font-size: 0.7rem; color: #6b7280; background: #f3f4f6; padding: 2px 8px; border-radius: 10px;">Optional</span>
            @endif
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label for="password" style="display: block; margin-bottom: 6px; font-weight: 500; font-size: 0.85rem; color: #374151;">
                    Password @if(!$user)<span style="color: #dc2626;">*</span>@endif
                </label>
                <input type="password" id="password" wire:model="password" placeholder="{{ $user ? 'Leave blank to keep current' : 'Min. 8 characters' }}"
                       style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.875rem; transition: all 0.2s;"
                       onfocus="this.style.borderColor='#007bff'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)';"
                       onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                @error('password') <span style="color: #dc2626; font-size: 0.7rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="password_confirmation" style="display: block; margin-bottom: 6px; font-weight: 500; font-size: 0.85rem; color: #374151;">
                    Confirm Password
                </label>
                <input type="password" id="password_confirmation" wire:model="password_confirmation" placeholder="Re-enter password"
                       style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.875rem; transition: all 0.2s;"
                       onfocus="this.style.borderColor='#007bff'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)';"
                       onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
            </div>
        </div>
    </div>

    <!-- Role Assignment Section -->
    <div style="margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 12px; padding-bottom: 6px; border-bottom: 1px solid #e5e7eb;">
            <span style="font-weight: 600; font-size: 0.85rem; color: #374151;">Role Assignment</span>
            <span style="color: #dc2626; font-size: 0.75rem;">*</span>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 10px;">
            @foreach($this->roles as $role)
                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 12px 16px; background: {{ $selectedRoles == $role->id ? '#dbeafe' : '#f9fafb' }}; border: 2px solid {{ $selectedRoles == $role->id ? '#3b82f6' : '#e5e7eb' }}; border-radius: 10px; transition: all 0.15s;"
                       onmouseenter="if(!this.querySelector('input').checked) { this.style.borderColor='#007bff'; this.style.background='#f3f4f6'; }"
                       onmouseleave="if(!this.querySelector('input').checked) { this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; }">
                    <input type="radio" wire:model.live="selectedRoles" value="{{ $role->id }}"
                           style="width: 18px; height: 18px; accent-color: #007bff; cursor: pointer;">
                    <div>
                        <span style="font-weight: {{ $selectedRoles == $role->id ? '600' : '500' }}; font-size: 0.9rem; color: {{ $selectedRoles == $role->id ? '#1e40af' : '#374151' }}; display: block;">
                            {{ $role->name }}
                        </span>
                        <span style="font-size: 0.7rem; color: #6b7280;">
                            {{ $role->permissions_count ?? $role->permissions->count() }} permissions
                        </span>
                    </div>
                </label>
            @endforeach
        </div>
        @error('selectedRoles') <span style="color: #dc2626; font-size: 0.7rem; margin-top: 8px; display: block;">{{ $message }}</span> @enderror
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; gap: 12px; justify-content: flex-end; padding-top: 16px; border-top: 1px solid #e5e7eb;">
        <button type="button" wire:click="$parent.closeForm" 
                style="padding: 10px 24px; background: #ffffff; border: 1px solid #d1d5db; border-radius: 8px; cursor: pointer; font-weight: 500; color: #374151; transition: all 0.2s;"
                onmouseenter="this.style.background='#f9fafb'; this.style.borderColor='#9ca3af';"
                onmouseleave="this.style.background='#ffffff'; this.style.borderColor='#d1d5db';">
            Cancel
        </button>
        <button type="button" wire:click="save" 
                style="padding: 10px 24px; background: #007bff; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: 500; transition: all 0.2s;"
                onmouseenter="this.style.background='#0056b3';"
                onmouseleave="this.style.background='#007bff';">
            {{ $user ? 'Update User' : 'Create User' }}
        </button>
    </div>
</div>
