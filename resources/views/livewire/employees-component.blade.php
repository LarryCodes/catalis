<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="controls">
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; flex: 1;">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search employees..."
                class="search-input"
                style="width: 200px;"
            >
            <select wire:model.live="filterPartnerId" class="search-input" style="width: 180px;">
                <option value="">All Partners</option>
                @foreach($partners as $partner)
                    <option value="{{ $partner->id }}">{{ $partner->company_name }}</option>
                @endforeach
            </select>
            @if($filterPartnerId)
            <select wire:model.live="filterSiteId" class="search-input" style="width: 150px;">
                <option value="">All Sites</option>
                @foreach($sites as $site)
                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="filterDepartmentId" class="search-input" style="width: 150px;">
                <option value="">All Depts</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            @endif
            <select wire:model.live="filterTenureId" class="search-input" style="width: 130px;">
                <option value="">All Tenures</option>
                @foreach($tenures as $tenure)
                    <option value="{{ $tenure->id }}">{{ $tenure->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="button-group">
            @can('create-employees')
                <button wire:click="openCreateForm" class="create-new-button">
                    <img src="{{ asset('images/plus.svg') }}" alt="Add" class="plus-icon">
                    <span class="create-new-text">Add Employee</span>
                </button>
            @endcan
        </div>
    </div>

    <div>
        @if($employees->count() > 0)
            <table class="people-table" data-table="employee" style="position: relative;">
                <thead>
                    <tr>
                        <th class="checkbox-cell" style="width: 20px;">
                            <input type="checkbox" id="select-all-employees" title="Select All" />
                        </th>
                        <th style="padding-right: 25px; width: 120px;">Employee #</th>
                        <th style="padding-right: 25px; width: 180px;">Full Name</th>
                        <th style="padding-right: 25px; width: 120px;">DOB</th>
                        <th style="padding-right: 25px; width: 140px;">Department</th>
                        <th style="padding-right: 25px; width: 140px;">Site</th>
                        <th style="padding-right: 25px; width: 120px;">Tenure</th>
                        <th style="padding-right: 25px; width: 140px;">Contact</th>
                        <th style="padding-right: 25px; width: 110px;">Daily Wage</th>
                        <th style="padding-right: 25px; width: 90px;">Status</th>
                        <th style="width: 60px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $index => $employee)
                        <tr style="animation: none; opacity: 1; transform: none;">
                            <td class="checkbox-cell">
                                <input type="checkbox" class="employee-checkbox" name="select_employee" value="{{ $employee->id }}">
                            </td>
                            <td>{{ $employee->employee_number }}</td>
                            <td>
                                <div class="person-name">{{ $employee->full_name }}</div>
                                <div class="person-meta">{{ $employee->nationality }}</div>
                            </td>
                            <td>{{ $employee->date_of_birth?->format('d M Y') ?? '—' }}</td>
                            <td>{{ $employee->department->name ?? '—' }}</td>
                            <td>{{ $employee->site->name ?? '—' }}</td>
                            <td>{{ $employee->tenure->name ?? '—' }}</td>
                            <td>
                                <div>{{ $employee->phone }}</div>
                                @if($employee->email)
                                <div class="person-meta">{{ $employee->email }}</div>
                                @endif
                            </td>
                            <td>UGX {{ number_format($employee->daily_wage, 2) }}</td>
                            <td>
                                <span class="status-pill {{ $employee->active ? 'active' : 'inactive' }}">
                                    {{ $employee->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-dropdown-wrapper" x-data="{ open: false }">
                                    <button class="actions-dropdown-btn" @click="open = !open" @click.away="open = false">
                                        <img src="{{ asset('images/bars-solid.svg') }}" alt="Actions">
                                    </button>
                                    <div class="actions-dropdown-panel" x-show="open" x-cloak>
                                        @can('edit-employees')
                                            <button class="action-item" wire:click="openEditForm({{ $employee->id }})" @click="open = false">
                                                <img src="{{ asset('images/wrench.svg') }}" alt="Edit">
                                                <span>Edit</span>
                                            </button>
                                        @endcan
                                        @can('delete-employees')
                                            <button class="action-item deactivate" 
                                                    wire:click="deactivateEmployee({{ $employee->id }})"
                                                    wire:confirm="Are you sure you want to deactivate this employee?"
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
            
            <div style="margin-top: 16px;">
                {{ $employees->links() }}
            </div>
        @else
            <div class="empty-state">
                <img src="{{ asset('images/people.svg') }}" alt="No employees" />
                <h3>No employees yet</h3>
                <p>Use the "Add Employee" button to create the first employee record.</p>
            </div>
        @endif
    </div>

    <!-- Modal -->
    @if($showForm)
    <div class="modal-overlay" wire:click.self="closeForm">
        <div class="modal-content employee-modal" wire:click.stop>
            <div class="modal-header">
                <h3>{{ $editingEmployee ? 'Edit Employee' : 'Add New Employee' }}</h3>
                <button wire:click="closeForm" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <livewire:employee-form :employee="$editingEmployee" :key="'employee-form-'.($editingEmployee ? $editingEmployee->id : 'new')" />
            </div>
        </div>
    </div>
    @endif
</div>
