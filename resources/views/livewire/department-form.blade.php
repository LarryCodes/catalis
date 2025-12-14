<div>
    <div class="form-group">
        <label for="name">Department Name *</label>
        <input
            type="text"
            id="name"
            wire:model="name"
            placeholder="Enter department name"
            required
        >
        @error('name') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea
            id="description"
            wire:model="description"
            placeholder="Enter department description"
            rows="3"
        ></textarea>
        @error('description') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions">
        <button type="button" wire:click="save" class="btn btn-primary">
            {{ $department ? 'Update Department' : 'Create Department' }}
        </button>
        <button type="button" wire:click="$parent.closeForm" class="btn btn-secondary">
            Cancel
        </button>
    </div>
</div>
