<div>
    <div class="form-group" style="margin-bottom: 16px;">
        <label for="name" style="display: block; margin-bottom: 6px; font-weight: 500;">Name *</label>
        <input type="text" id="name" wire:model="name" placeholder="Enter full name" 
               style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.875rem;">
        @error('name') <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group" style="margin-bottom: 16px;">
        <label for="email" style="display: block; margin-bottom: 6px; font-weight: 500;">Email *</label>
        <input type="email" id="email" wire:model="email" placeholder="Enter email address"
               style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.875rem;">
        @error('email') <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group" style="margin-bottom: 16px;">
        <label for="password" style="display: block; margin-bottom: 6px; font-weight: 500;">
            Password {{ $user ? '(leave blank to keep current)' : '*' }}
        </label>
        <input type="password" id="password" wire:model="password" placeholder="Enter password"
               style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.875rem;">
        @error('password') <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group" style="margin-bottom: 16px;">
        <label for="password_confirmation" style="display: block; margin-bottom: 6px; font-weight: 500;">Confirm Password</label>
        <input type="password" id="password_confirmation" wire:model="password_confirmation" placeholder="Confirm password"
               style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.875rem;">
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 500;">Assign Role *</label>
        <div style="display: flex; flex-wrap: wrap; gap: 12px;">
            @foreach($this->roles as $role)
                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="radio" wire:model="selectedRoles" value="{{ $role->id }}"
                           style="width: 16px; height: 16px;">
                    <span>{{ $role->name }}</span>
                </label>
            @endforeach
        </div>
        @error('selectedRoles') <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions" style="display: flex; gap: 12px; justify-content: flex-end;">
        <button type="button" wire:click="$parent.closeForm" 
                style="padding: 10px 20px; background: #f5f5f5; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer;">
            Cancel
        </button>
        <button type="button" wire:click="save" 
                style="padding: 10px 20px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
            {{ $user ? 'Update User' : 'Create User' }}
        </button>
    </div>
</div>
