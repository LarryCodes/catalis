<div>
    <!-- Company Details Section -->
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

    <div class="form-row">
        <div class="form-group">
            <label for="company_email">Company Email *</label>
            <input
                type="email"
                id="company_email"
                wire:model="company_email"
                placeholder="Enter company email"
                required
            >
            @error('company_email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="company_phone">Company Phone</label>
            <input
                type="text"
                id="company_phone"
                wire:model="company_phone"
                placeholder="Enter company phone"
            >
            @error('company_phone') <span class="error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="company_address">Company Address</label>
        <textarea
            id="company_address"
            wire:model="company_address"
            placeholder="Enter company address"
            rows="2"
        ></textarea>
        @error('company_address') <span class="error">{{ $message }}</span> @enderror
    </div>

    <!-- Contact Person Accordion -->
    <div class="accordion-section">
        <button type="button" class="accordion-header" wire:click="toggleContactPerson">
            <span>Contact Person</span>
            <span class="accordion-icon">{{ $contactPersonOpen ? '−' : '+' }}</span>
        </button>
        
        @if($contactPersonOpen)
        <div class="accordion-content">
            <div class="form-row">
                <div class="form-group">
                    <label for="contact_person">Name</label>
                    <input
                        type="text"
                        id="contact_person"
                        wire:model="contact_person"
                        placeholder="Contact person name"
                    >
                    @error('contact_person') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="contact_person_title">Title / Position</label>
                    <input
                        type="text"
                        id="contact_person_title"
                        wire:model="contact_person_title"
                        placeholder="e.g. HR Manager"
                    >
                    @error('contact_person_title') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="contact_email">Email</label>
                    <input
                        type="email"
                        id="contact_email"
                        wire:model="contact_email"
                        placeholder="Contact person email"
                    >
                    @error('contact_email') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="contact_phone">Phone</label>
                    <input
                        type="text"
                        id="contact_phone"
                        wire:model="contact_phone"
                        placeholder="Contact person phone"
                    >
                    @error('contact_phone') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        @endif
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
