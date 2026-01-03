<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div>
        @if($this->roles->count() > 0)
            <table class="people-table" data-table="roles" style="position: relative;">
                <thead>
                    <tr>
                        <th class="checkbox-cell" style="width: 20px;">
                            <input type="checkbox" id="select-all-roles" title="Select All" />
                        </th>
                        <th style="width: 40px;">#</th>
                        <th style="padding-right: 25px; width: 200px;">Role Name</th>
                        <th style="padding-right: 25px;">Permissions Count</th>
                        <th style="width: 80px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->roles as $index => $role)
                        <tr style="animation: none; opacity: 1; transform: none;">
                            <td class="checkbox-cell">
                                <input type="checkbox" class="role-checkbox" name="select_role" value="{{ $role->id }}">
                            </td>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->permissions_count }} permissions</td>
                            <td>
                                <div class="actions-dropdown-wrapper" x-data="{ open: false }">
                                    <button class="actions-dropdown-btn" @click="open = !open" @click.away="open = false">
                                        <img src="{{ asset('images/bars-solid.svg') }}" alt="Actions">
                                    </button>
                                    <div class="actions-dropdown-panel" x-show="open" x-cloak>
                                        @can('manage-roles')
                                            <button class="action-item" wire:click="openEditForm({{ $role->id }})" @click="open = false">
                                                <img src="{{ asset('images/wrench.svg') }}" alt="Edit">
                                                <span>Edit</span>
                                            </button>
                                            @if($role->name !== 'Super Admin')
                                            <button class="action-item deactivate" 
                                                    wire:click="deleteRole({{ $role->id }})"
                                                    wire:confirm="Are you sure you want to delete this role?"
                                                    @click="open = false">
                                                <img src="{{ asset('images/xdelete.svg') }}" alt="Delete">
                                                <span>Delete</span>
                                            </button>
                                            @endif
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
                <h3>No roles found</h3>
                <p>Use the "Add Role" button to create a new role.</p>
            </div>
        @endif
    </div>

    @if($showForm)
    <div class="modal-overlay" wire:click.self="closeForm">
        <div class="modal-content" wire:click.stop style="max-width: 600px;">
            <div class="modal-header">
                <h3>{{ $editingRole ? 'Edit Role' : 'Add New Role' }}</h3>
                <button wire:click="closeForm" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <livewire:role-form :role="$editingRole" :key="'role-form-'.($editingRole ? $editingRole->id : 'new')" />
            </div>
        </div>
    </div>
    @endif
</div>
