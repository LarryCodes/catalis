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


    <div>
        @if($tenures->count() > 0)
            <table class="people-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th style="padding-right: 25px; width: 250px;">Tenure Name</th>
                        <th style="padding-right: 25px;">Description</th>
                        <th style="padding-right: 25px; width: 100px;">Employees</th>
                        <th style="padding-right: 25px; width: 90px;">Status</th>
                        <th style="width: 60px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenures as $index => $tenure)
                        <tr style="animation: none; opacity: 1; transform: none;">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tenure->name }}</td>
                            <td>{{ Str::limit($tenure->description, 80) ?: '—' }}</td>
                            <td>{{ $tenure->employees_count }}</td>
                            <td>
                                <span class="status-pill {{ $tenure->active ? 'active' : 'inactive' }}">
                                    {{ $tenure->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-dropdown-wrapper" x-data="{ open: false }">
                                    <button class="actions-dropdown-btn" @click="open = !open" @click.away="open = false">
                                        <img src="{{ asset('images/bars-solid.svg') }}" alt="Actions">
                                    </button>
                                    <div class="actions-dropdown-panel" x-show="open" x-cloak>
                                        @can('edit-tenures')
                                            <button class="action-item" wire:click="openEditForm({{ $tenure->id }})" @click="open = false">
                                                <img src="{{ asset('images/wrench.svg') }}" alt="Edit">
                                                <span>Edit</span>
                                            </button>
                                        @endcan
                                        @can('delete-tenures')
                                            <button class="action-item deactivate" 
                                                    wire:click="deactivateTenure({{ $tenure->id }})"
                                                    wire:confirm="Are you sure you want to deactivate this tenure?"
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
                <h3>No tenures yet</h3>
                <p>Use the "Add Tenure" button to create the first tenure record.</p>
            </div>
        @endif
    </div>

    <!-- Modal -->
    @if($showForm)
    <div class="modal-overlay" wire:click.self="closeForm">
        <div class="modal-content" wire:click.stop>
            <div class="modal-header">
                <h3>{{ $editingTenure ? 'Edit Tenure' : 'Add New Tenure' }}</h3>
                <button wire:click="closeForm" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <livewire:tenure-form :tenure="$editingTenure" :key="'tenure-form-'.($editingTenure ? $editingTenure->id : 'new')" />
            </div>
        </div>
    </div>
    @endif
</div>
