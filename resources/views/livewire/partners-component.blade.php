<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="controls">
        <div class="search-container">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search partners..."
                class="search-input"
            >
        </div>
        <div class="button-group">
            @can('create-partners')
                <button wire:click="openCreateForm" class="add-btn">
                    <img src="{{ asset('images/plus-solid.svg') }}" alt="Add">
                    Add New
                </button>
            @endcan
        </div>
    </div>

    <div class="table-container">
        @if($this->partners->count() > 0)
            <table class="quotation-table">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Contact Person</th>
                        <th>Contact Email</th>
                        <th>Contact Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->partners as $partner)
                        <tr>
                            <td>{{ $partner->company_name }}</td>
                            <td>{{ $partner->contact_person ?: '-' }}</td>
                            <td>{{ $partner->contact_email }}</td>
                            <td>{{ $partner->contact_phone ?: '-' }}</td>
                            <td>{{ Str::limit($partner->company_address, 50) ?: '-' }}</td>
                            <td>
                                <span class="status-badge {{ $partner->active ? 'active' : 'inactive' }}">
                                    {{ $partner->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @can('edit-partners')
                                        <button wire:click="openEditForm({{ $partner->id }})" class="action-btn edit-btn">
                                            Edit
                                        </button>
                                    @endcan
                                    @can('delete-partners')
                                        <button wire:click="deactivatePartner({{ $partner->id }})"
                                                wire:confirm="Are you sure you want to deactivate this partner?"
                                                class="action-btn deactivate-btn">
                                            Deactivate
                                        </button>
                                    @endcan
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
    <div wire:show="showForm" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ $editingPartner ? 'Edit Partner' : 'Add New Partner' }}</h3>
                <button wire:click="closeForm" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <livewire:partner-form :partner="$editingPartner" :key="'partner-form-'.($editingPartner ? $editingPartner->id : 'new')" />
            </div>
        </div>
    </div>
</div>
