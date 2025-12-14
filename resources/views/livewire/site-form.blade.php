<div>
    <div class="form-group">
        <label for="name">Site Name *</label>
        <input
            type="text"
            id="name"
            wire:model="name"
            placeholder="Enter site name"
            required
        >
        @error('name') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="address">Address</label>
        <input
            type="text"
            id="address"
            wire:model="address"
            placeholder="Enter site address"
        >
        @error('address') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea
            id="description"
            wire:model="description"
            placeholder="Enter site description"
            rows="3"
        ></textarea>
        @error('description') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions">
        <button type="button" wire:click="save" class="btn btn-primary">
            {{ $site ? 'Update Site' : 'Create Site' }}
        </button>
        <button type="button" wire:click="$parent.closeForm" class="btn btn-secondary">
            Cancel
        </button>
    </div>
</div>
