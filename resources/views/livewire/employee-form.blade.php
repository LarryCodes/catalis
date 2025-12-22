<div>
    <!-- Employment Details Section -->
    <div class="accordion-section">
        <button type="button" class="accordion-header" wire:click="toggleSection('employment')">
            <span class="accordion-title">
                <span class="accordion-icon">{{ $openSections['employment'] ? '−' : '+' }}</span>
                Employment Details
            </span>
            <span class="accordion-status">
                @if($partner_id && $site_id && $department_id && $tenure_id)
                    <span class="status-complete">✓</span>
                @else
                    <span class="status-incomplete">Required</span>
                @endif
            </span>
        </button>
        <div class="accordion-content" x-show="$wire.openSections.employment" x-collapse>
            <div class="form-row">
                <div class="form-group">
                    <label for="partner_id">Partner *</label>
                    <select id="partner_id" wire:model.live="partner_id">
                        <option value="">Select Partner</option>
                        @foreach($partners as $partner)
                            <option value="{{ $partner->id }}">{{ $partner->company_name }}</option>
                        @endforeach
                    </select>
                    @error('partner_id') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="tenure_id">Tenure *</label>
                    <select id="tenure_id" wire:model="tenure_id">
                        <option value="">Select Tenure</option>
                        @foreach($tenures as $tenure)
                            <option value="{{ $tenure->id }}">{{ $tenure->name }}</option>
                        @endforeach
                    </select>
                    @error('tenure_id') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="site_id">Site *</label>
                    <select id="site_id" wire:model="site_id" @if(!$partner_id) disabled @endif>
                        <option value="">{{ $partner_id ? 'Select Site' : 'Select Partner First' }}</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}">{{ $site->name }}</option>
                        @endforeach
                    </select>
                    @error('site_id') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="department_id">Department *</label>
                    <select id="department_id" wire:model="department_id" @if(!$partner_id) disabled @endif>
                        <option value="">{{ $partner_id ? 'Select Department' : 'Select Partner First' }}</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Personal Information Section -->
    <div class="accordion-section">
        <button type="button" class="accordion-header" wire:click="toggleSection('personal')">
            <span class="accordion-title">
                <span class="accordion-icon">{{ $openSections['personal'] ? '−' : '+' }}</span>
                Personal Information
            </span>
            <span class="accordion-status">
                @if($first_name && $last_name && $date_of_birth && $nationality && $national_id_number && $marital_status)
                    <span class="status-complete">✓</span>
                @else
                    <span class="status-incomplete">Required</span>
                @endif
            </span>
        </button>
        <div class="accordion-content" x-show="$wire.openSections.personal" x-collapse>
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" id="first_name" wire:model="first_name" placeholder="Enter first name">
                    @error('first_name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" id="last_name" wire:model="last_name" placeholder="Enter last name">
                    @error('last_name') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth *</label>
                    <input type="date" id="date_of_birth" wire:model="date_of_birth">
                    @error('date_of_birth') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="marital_status">Marital Status *</label>
                    <select id="marital_status" wire:model="marital_status">
                        <option value="">Select Status</option>
                        @foreach($maritalStatuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('marital_status') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="nationality">Nationality *</label>
                    <input type="text" id="nationality" wire:model="nationality" placeholder="Enter nationality">
                    @error('nationality') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="national_id_number">National ID Number *</label>
                    <input type="text" id="national_id_number" wire:model="national_id_number" placeholder="Enter NIN">
                    @error('national_id_number') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="nssf_number">NSSF Number</label>
                    <input type="text" id="nssf_number" wire:model="nssf_number" placeholder="Enter NSSF number">
                    @error('nssf_number') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="tin_number">TIN Number</label>
                    <input type="text" id="tin_number" wire:model="tin_number" placeholder="Enter TIN">
                    @error('tin_number') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Contact & Address Section -->
    <div class="accordion-section">
        <button type="button" class="accordion-header" wire:click="toggleSection('contact')">
            <span class="accordion-title">
                <span class="accordion-icon">{{ $openSections['contact'] ? '−' : '+' }}</span>
                Contact & Address
            </span>
            <span class="accordion-status">
                @if($phone && $address && $district && $area_lc1)
                    <span class="status-complete">✓</span>
                @else
                    <span class="status-incomplete">Required</span>
                @endif
            </span>
        </button>
        <div class="accordion-content" x-show="$wire.openSections.contact" x-collapse>
            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Phone *</label>
                    <input type="text" id="phone" wire:model="phone" placeholder="Enter phone number">
                    @error('phone') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" wire:model="email" placeholder="Enter email address">
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="district">District *</label>
                    <input type="text" id="district" wire:model="district" placeholder="Enter district">
                    @error('district') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="area_lc1">Area / LC1 *</label>
                    <input type="text" id="area_lc1" wire:model="area_lc1" placeholder="Enter area or LC1">
                    @error('area_lc1') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="address">Full Address *</label>
                <textarea id="address" wire:model="address" placeholder="Enter full address" rows="2"></textarea>
                @error('address') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <!-- Next of Kin Section -->
    <div class="accordion-section">
        <button type="button" class="accordion-header" wire:click="toggleSection('nextOfKin')">
            <span class="accordion-title">
                <span class="accordion-icon">{{ $openSections['nextOfKin'] ? '−' : '+' }}</span>
                Next of Kin
            </span>
            <span class="accordion-status">
                @if($next_of_kin_name && $next_of_kin_relationship && $next_of_kin_phone && $next_of_kin_address)
                    <span class="status-complete">✓</span>
                @else
                    <span class="status-incomplete">Required</span>
                @endif
            </span>
        </button>
        <div class="accordion-content" x-show="$wire.openSections.nextOfKin" x-collapse>
            <div class="form-row">
                <div class="form-group">
                    <label for="next_of_kin_name">Name *</label>
                    <input type="text" id="next_of_kin_name" wire:model="next_of_kin_name" placeholder="Enter name">
                    @error('next_of_kin_name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="next_of_kin_relationship">Relationship *</label>
                    <input type="text" id="next_of_kin_relationship" wire:model="next_of_kin_relationship" placeholder="e.g. Spouse, Parent">
                    @error('next_of_kin_relationship') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="next_of_kin_phone">Phone *</label>
                    <input type="text" id="next_of_kin_phone" wire:model="next_of_kin_phone" placeholder="Enter phone number">
                    @error('next_of_kin_phone') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="next_of_kin_address">Address *</label>
                    <input type="text" id="next_of_kin_address" wire:model="next_of_kin_address" placeholder="Enter address">
                    @error('next_of_kin_address') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Remuneration Details Section -->
    <div class="accordion-section">
        <button type="button" class="accordion-header" wire:click="toggleSection('remuneration')">
            <span class="accordion-title">
                <span class="accordion-icon">{{ $openSections['remuneration'] ? '−' : '+' }}</span>
                Remuneration Details
            </span>
            <span class="accordion-status">
                @if($daily_wage)
                    <span class="status-complete">✓</span>
                @else
                    <span class="status-incomplete">Required</span>
                @endif
            </span>
        </button>
        <div class="accordion-content" x-show="$wire.openSections.remuneration" x-collapse>
            <div class="form-row">
                <div class="form-group">
                    <label for="daily_wage">Daily Wage (UGX) *</label>
                    <input type="number" id="daily_wage" wire:model="daily_wage" placeholder="Enter daily wage" step="0.01" min="0">
                    @error('daily_wage') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="management_fee">Management Fee (UGX)</label>
                    <input type="number" id="management_fee" wire:model="management_fee" placeholder="Enter management fee" step="0.01" min="0">
                    @error('management_fee') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" id="bank_name" wire:model="bank_name" placeholder="Enter bank name">
                    @error('bank_name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="bank_branch">Branch</label>
                    <input type="text" id="bank_branch" wire:model="bank_branch" placeholder="Enter branch">
                    @error('bank_branch') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="bank_account_name">Account Name</label>
                    <input type="text" id="bank_account_name" wire:model="bank_account_name" placeholder="Enter account name">
                    @error('bank_account_name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="bank_account_number">Account Number</label>
                    <input type="text" id="bank_account_number" wire:model="bank_account_number" placeholder="Enter account number">
                    @error('bank_account_number') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 20px;">
        <button type="button" wire:click="save" class="btn btn-primary">
            {{ $employee ? 'Update Employee' : 'Create Employee' }}
        </button>
        <button type="button" wire:click="$parent.closeForm" class="btn btn-secondary">
            Cancel
        </button>
    </div>
</div>
