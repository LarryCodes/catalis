<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif


    <div>
        @if($this->partners->count() > 0)
            <table class="people-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th style="padding-right: 25px; width: 120px;">Partner Code</th>
                        <th style="padding-right: 25px; width: 180px;">Company</th>
                        <th style="padding-right: 25px; width: 180px;">Email</th>
                        <th style="padding-right: 25px; width: 120px;">Phone</th>
                        <th style="padding-right: 25px; width: 180px;">Address</th>
                        <th style="padding-right: 25px; width: 150px;">Contact Person</th>
                        <th style="padding-right: 25px; width: 90px;">Headcount</th>
                        <th style="padding-right: 25px; width: 90px;">Status</th>
                        <th style="width: 60px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->partners as $index => $partner)
                        <tr style="animation: none; opacity: 1; transform: none;">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $partner->partner_code }}</td>
                            <td>{{ $partner->company_name }}</td>
                            <td>{{ $partner->company_email ?: '—' }}</td>
                            <td>{{ $partner->company_phone ?: '—' }}</td>
                            <td>{{ Str::limit($partner->company_address, 40) ?: '—' }}</td>
                            <td>
                                @if($partner->contact_person)
                                    <div>{{ $partner->contact_person }}</div>
                                    @if($partner->contact_person_title)
                                        <div class="person-meta">{{ $partner->contact_person_title }}</div>
                                    @endif
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $partner->employees_count }}</td>
                            <td>
                                <span class="status-pill {{ $partner->active ? 'active' : 'inactive' }}">
                                    {{ $partner->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-dropdown-wrapper" x-data="{ open: false }">
                                    <button class="actions-dropdown-btn" @click="open = !open" @click.away="open = false">
                                        <img src="{{ asset('images/bars-solid.svg') }}" alt="Actions">
                                    </button>
                                    <div class="actions-dropdown-panel" x-show="open" x-cloak>
                                        @can('edit-partners')
                                            <button class="action-item" wire:click="openEditForm({{ $partner->id }})" @click="open = false">
                                                <img src="{{ asset('images/wrench.svg') }}" alt="Edit">
                                                <span>Edit</span>
                                            </button>
                                        @endcan
                                        @can('delete-partners')
                                            <button class="action-item deactivate" 
                                                    wire:click="deactivatePartner({{ $partner->id }})"
                                                    wire:confirm="Are you sure you want to deactivate this partner?"
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
                <h3>No partners yet</h3>
                <p>Use the "Add New" button to register your first client.</p>
            </div>
        @endif
    </div>

    <!-- Modal -->
    @if($showForm)
    <div class="modal-overlay" wire:click.self="closeForm">
        <div class="modal-content" wire:click.stop>
            <div class="modal-header">
                <h3>{{ $editingPartner ? 'Edit Partner' : 'Add New Partner' }}</h3>
                <button wire:click="closeForm" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <livewire:partner-form :partner="$editingPartner" :key="'partner-form-'.($editingPartner ? $editingPartner->id : 'new')" />
            </div>
        </div>
    </div>
    @endif
</div>
