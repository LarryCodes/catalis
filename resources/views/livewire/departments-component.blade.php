<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-error" style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;">
            {{ session('error') }}
        </div>
    @endif

    <div class="controls">
        <div style="display: flex; gap: 12px; align-items: center; flex: 1;">
            <select 
                wire:model.live="selectedPartnerId" 
                class="search-input"
                style="width: 250px; height: 40px; line-height: 1.5;"
            >
                <option value="">Select Partner</option>
                <option value="all">All Partners</option>
                @foreach($partners as $partner)
                    <option value="{{ $partner->id }}">{{ $partner->company_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        @if(!$selectedPartnerId)
            <div class="empty-state">
                <h3>Select a Partner</h3>
                <p>Please select a partner from the dropdown above to view and manage their departments.</p>
            </div>
        @elseif($departments->count() > 0)
            <table class="people-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        @if($selectedPartnerId === 'all')
                        <th style="padding-right: 25px; width: 180px;">Partner</th>
                        @endif
                        <th style="padding-right: 25px; width: 200px;">Department Name</th>
                        <th style="padding-right: 25px;">Description</th>
                        <th style="padding-right: 25px; width: 100px;">Employees</th>
                        <th style="padding-right: 25px; width: 90px;">Status</th>
                        <th style="width: 60px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $index => $department)
                        <tr style="animation: none; opacity: 1; transform: none;">
                            <td>{{ $index + 1 }}</td>
                            @if($selectedPartnerId === 'all')
                            <td>{{ $department->partner->company_name ?? '—' }}</td>
                            @endif
                            <td>{{ $department->name }}</td>
                            <td>{{ Str::limit($department->description, 80) ?: '—' }}</td>
                            <td>{{ $department->employees_count }}</td>
                            <td>
                                <span class="status-pill {{ $department->active ? 'active' : 'inactive' }}">
                                    {{ $department->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-dropdown-wrapper" x-data="{ open: false }">
                                    <button class="actions-dropdown-btn" @click="open = !open" @click.away="open = false">
                                        <img src="{{ asset('images/bars-solid.svg') }}" alt="Actions">
                                    </button>
                                    <div class="actions-dropdown-panel" x-show="open" x-cloak>
                                        @can('edit-departments')
                                            <button class="action-item" wire:click="openEditForm({{ $department->id }})" @click="open = false">
                                                <img src="{{ asset('images/wrench.svg') }}" alt="Edit">
                                                <span>Edit</span>
                                            </button>
                                        @endcan
                                        @can('delete-departments')
                                            <button class="action-item deactivate" 
                                                    wire:click="deactivateDepartment({{ $department->id }})"
                                                    wire:confirm="Are you sure you want to deactivate this department?"
                                                    @click="open = false">
                                                <img src="{{ asset('images/xdelete.svg') }}" alt="Deactivate">
                                                <span>Deactivate</span>
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <h3>No departments yet</h3>
                <p>Use the "Add Department" button to create the first department for this partner.</p>
            </div>
        @endif
    </div>

    <!-- Modal -->
    @if($showForm)
    <div class="modal-overlay" wire:click.self="closeForm">
        <div class="modal-content" wire:click.stop>
            <div class="modal-header">
                <h3>{{ $editingDepartment ? 'Edit Department' : 'Add New Department for ' . $partners->firstWhere('id', $selectedPartnerId)?->company_name }}</h3>
                <button wire:click="closeForm" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <livewire:department-form :department="$editingDepartment" :partner-id="$selectedPartnerId" :key="'department-form-'.($editingDepartment ? $editingDepartment->id : 'new-'.$selectedPartnerId)" />
            </div>
        </div>
    </div>
    @endif
</div>
