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
        @if($this->users->count() > 0)
            <table class="people-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th style="padding-right: 25px; width: 200px;">Name</th>
                        <th style="padding-right: 25px; width: 250px;">Email</th>
                        <th style="padding-right: 25px;">Roles</th>
                        <th style="width: 80px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->users as $index => $user)
                        <tr>
                            <td>{{ $this->users->firstItem() + $index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="status-pill active" style="margin-right: 4px;">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="actions-dropdown-wrapper" x-data="{ open: false }">
                                    <button class="actions-dropdown-btn" @click="open = !open" @click.away="open = false">
                                        <img src="{{ asset('images/bars-solid.svg') }}" alt="Actions">
                                    </button>
                                    <div class="actions-dropdown-panel" x-show="open" x-cloak>
                                        @can('manage-users')
                                            <button class="action-item" wire:click="openEditForm({{ $user->id }})" @click="open = false">
                                                <img src="{{ asset('images/wrench.svg') }}" alt="Edit">
                                                <span>Edit</span>
                                            </button>
                                            @if($user->id !== auth()->id())
                                            <button class="action-item deactivate" 
                                                    wire:click="deleteUser({{ $user->id }})"
                                                    wire:confirm="Are you sure you want to delete this user?"
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
            
            <div style="margin-top: 16px;">
                {{ $this->users->links() }}
            </div>
        @else
            <div class="empty-state">
                <h3>No users found</h3>
                <p>Use the "Add User" button to create a new user.</p>
            </div>
        @endif
    </div>

    <!-- Modal -->
    @if($showForm)
    <div class="modal-overlay" wire:click.self="closeForm">
        <div class="modal-content" wire:click.stop>
            <div class="modal-header">
                <h3>{{ $editingUser ? 'Edit User' : 'Add New User' }}</h3>
                <button wire:click="closeForm" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <livewire:user-form :user="$editingUser" :key="'user-form-'.($editingUser ? $editingUser->id : 'new')" />
            </div>
        </div>
    </div>
    @endif
</div>
