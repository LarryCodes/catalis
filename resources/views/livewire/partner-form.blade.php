<div>
    <div class="form-group">
        <label for="company_name">Company Name *</label>
        <input
            type="text"
            id="company_name"
            wire:model="company_name"
            placeholder="Enter company name"
            required
        >
        @error('company_name') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="contact_person">Contact Person</label>
        <input
            type="text"
            id="contact_person"
            wire:model="contact_person"
            placeholder="Enter contact person name"
        >
        @error('contact_person') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="contact_email">Contact Email *</label>
        <input
            type="email"
            id="contact_email"
            wire:model="contact_email"
            placeholder="Enter contact email"
            required
        >
        @error('contact_email') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="contact_phone">Contact Phone</label>
        <input
            type="text"
            id="contact_phone"
            wire:model="contact_phone"
            placeholder="Enter contact phone"
        >
        @error('contact_phone') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="company_address">Company Address</label>
        <textarea
            id="company_address"
            wire:model="company_address"
            placeholder="Enter company address"
            rows="3"
        ></textarea>
        @error('company_address') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions">
        <button type="button" wire:click="save" class="btn btn-primary">
            {{ $partner ? 'Update Partner' : 'Create Partner' }}
        </button>
        <button type="button" wire:click="$parent.closeForm" class="btn btn-secondary">
            Cancel
        </button>
    </div>
</div>
